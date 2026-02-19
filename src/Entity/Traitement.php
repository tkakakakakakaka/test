<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
class Traitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $medicament = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(length: 255)]
    private ?string $contenant = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(length: 255)]
    private ?string $dose = null;

    #[ORM\Column]
    private ?int $frequence = null;

    #[ORM\ManyToOne(inversedBy: 'traitements')]
    private ?Consultation $consultation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicament(): ?string
    {
        return $this->medicament;
    }

    public function setMedicament(string $medicament): static
    {
        $this->medicament = $medicament;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getContenant(): ?string
    {
        return $this->contenant;
    }

    public function setContenant(string $contenant): static
    {
        $this->contenant = $contenant;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose(string $dose): static
    {
        $this->dose = $dose;

        return $this;
    }

    public function getFrequence(): ?int
    {
        return $this->frequence;
    }

    public function setFrequence(int $frequence): static
    {
        $this->frequence = $frequence;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
    }
}
