<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



#[UniqueEntity(
    fields: 'email',
    message: "Cet email appartient déjà à l'un de vos contacts, veuillez en choisir un autre.",
)]
#[UniqueEntity(
    fields: 'phone',
    message: "Ce numéro de téléphone appartient déjà à l'un de vos contacts, veuillez en choisir un autre.",
)]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le prénom ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;


    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;


    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "L'email ne doit pas dépasser {{ limit }} caractères.",
    )]
    #[Assert\Email(
        message: "L'email {{ value }} est invalide."
    )]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;


    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    #[Assert\Length(
        min: 6,
        minMessage: "Le numéro de téléphone doit contenir au minimum {{ limit }} caractères.",
        max: 30,
        maxMessage: "Le numéro de téléphone doit contenir au maximum {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[0-9\+\-\s]+$/',
        match: true,
        message: "Le numéro de téléphone est invalide.",
    )]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $phone = null;


    #[Assert\Length(
        max: 500,
        maxMessage: "Le commentaire doit contenir au maximum {{ limit }} caractères."
    )]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
