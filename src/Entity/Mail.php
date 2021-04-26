<?php

namespace App\Entity;

use App\Repository\MailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MailRepository::class)
 */
class Mail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Invalid email address!")
     */
    private $FromEmail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Invalid email address!")
     */
    private $ReceiverEmail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5)
     */
    private $Subject;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5)
     */
    private $Content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Attachment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromEmail(): ?string
    {
        return $this->FromEmail;
    }

    public function setFromEmail(string $FromEmail): self
    {
        $this->FromEmail = $FromEmail;

        return $this;
    }

    public function getReceiverEmail(): ?string
    {
        return $this->ReceiverEmail;
    }

    public function setReceiverEmail(string $ReceiverEmail): self
    {
        $this->ReceiverEmail = $ReceiverEmail;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(string $Subject): self
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getAttachment(): ?string
    {
        return $this->Attachment;
    }

    public function setAttachment(?string $Attachment): self
    {
        $this->Attachment = $Attachment;

        return $this;
    }
}
