<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Promotion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Gender;

    /**
     * @ORM\Column(type="date")
     */
    private $Birthdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): self
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->Promotion;
    }

    public function setPromotion(string $Promotion): self
    {
        $this->Promotion = $Promotion;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): self
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->Birthdate;
    }

    public function setBirthdate(\DateTimeInterface $Birthdate): self
    {
        $this->Birthdate = $Birthdate;

        return $this;
    }
}
