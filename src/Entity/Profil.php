<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $lastName = null;
    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $shortPitch = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;
    
    #[ORM\Column(length: 255)]
    private ?string $hobby = null;

    #[ORM\Column(length: 35)]
    private ?string $title1 = null;

    #[ORM\Column(length: 35)]
    private ?string $title2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getlastName(): ?string
    {
        return $this->lastName;
    }

    public function setlastName(string $name): self
    {
        $this->lastName = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getShortPitch(): ?string
    {
        return $this->shortPitch;
    }

    public function setShortPitch(string $shortPitch): self
    {
        $this->shortPitch = $shortPitch;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getHobby(): ?string
    {
        return $this->hobby;
    }

    public function setHobby(string $hobby): self
    {
        $this->hobby = $hobby;

        return $this;
    }

    public function getTitle1(): ?string
    {
        return $this->title1;
    }

    public function setTitle1(string $title1): self
    {
        $this->title1 = $title1;

        return $this;
    }

    public function getTitle2(): ?string
    {
        return $this->title2;
    }

    public function setTitle2(string $title2): self
    {
        $this->title2 = $title2;

        return $this;
    }
}
