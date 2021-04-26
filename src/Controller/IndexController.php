<?php

namespace App\Controller;

use App\Entity\Mail;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Student;
use App\Form\MailType;
use Symfony\Component\Mime\Email;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Omines\DataTablesBundle\Column\TextColumn;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MailerInterface $mailer, DataTableFactory $dataTableFactory, String $uploadDir)
    {
        $mail = new Mail();

        $form = $this->createForm(MailType::class, $mail);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $file = $form['Attachment']->getData();
            $file->move($uploadDir, $file->getClientOriginalName());
             $email = (new Email())
                ->from($mail->getFromEmail())
                ->to($mail->getReceiverEmail())
                ->subject($mail->getSubject())
                ->text($mail->getContent())
                ->attachFromPath($uploadDir.'/'.$file->getClientOriginalName());

             $mailer->send($email);
        }

        $table = $dataTableFactory->create()
            ->add('Firstname', TextColumn::class)
            ->add('Lastname', TextColumn::class)
            ->add('Promotion', TextColumn::class)
            ->add('Gender', TextColumn::class)
            ->add('Birthdate', DateTimeColumn::class)
            ->createAdapter(ORMAdapter::class, [
                'entity' => Student::class,
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('index/index.html.twig', [
            'datatable' =>  $table,
            'formEmail' =>  $form->createView()
        ]);
    }

    /**
     * @Route("/export", name="export")
     */
    public function export(StudentRepository $repo){
        $students = $repo->findAll();
        
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('index/export.html.twig', [
            'students'  =>  $students,
            'exportTime'=>  new \DateTime()
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("student_list.pdf", [
            "Attachment" => false
        ]);

        return $this->render('index/export.html.twig', [
            'students'  =>  $students,
            'exportTime'=>  new \DateTime()
        ]);
        
    }

    /**
     * @Route("/populate", name="populate")
     */
    public function populate(ManagerRegistry $managerRegistry){

        $promotion = ['Licence', 'Master 1', 'Master 2'];

        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, "https://random-data-api.com/api/users/random_user");

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $users = [];
        for($i = 1; $i <= 50; $i++){
            // curl_exec() executes the started curl session
            // $output contains the output string
            $output = curl_exec($curl);
            $user = json_decode($output);

            if($user->gender == "Male" || $user->gender == "Female"){
                $student = new Student();

                $student->setFirstname($user->first_name)
                        ->setLastname($user->last_name)
                        ->setPromotion($promotion[random_int(0, 2)])
                        ->setGender($user->gender)
                        ->setBirthdate(new \DateTime($user->date_of_birth));
                
                $manager = $managerRegistry->getManager();
                $manager->persist($student);
                $manager->flush();
            }else{
                $i = $i-1;
            }
        }

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        return $this->render('index/populate.html.twig');
    }

}
