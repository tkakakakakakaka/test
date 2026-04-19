<?php

namespace App\Entity;

use App\Repository\DirecteurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: DirecteurRepository::class)]
#[ApiResource]
class Directeur extends Utilisateur
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private mixed $signatureOfficielle = null;

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getSignatureOfficelle(): mixed
    {
        return $this->signatureOfficielle;
    }

    public function setSignatureOfficelle(mixed $signatureOfficelle): static
    {
        $this->signatureOfficielle = $signatureOfficelle;

        return $this;
    }

    public function getRoles(): array
    {
        return array_unique([...parent::getRoles(), 'ROLE_DIRECTEUR']);
    }
}
