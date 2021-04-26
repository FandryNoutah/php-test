<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for($i = 1; $i <= 50; $i++){
            $student = new Student();

            $student->setFirstname($faker->firstName('male'))
                    ->setLastname($faker->lastName('male'))
                    ->setPromotion('Licence')
                    ->setGender('Male')
                    ->setBirthdate(new \DateTime());
            $manager->persist($student);
        }

        $manager->flush();
    }
}
