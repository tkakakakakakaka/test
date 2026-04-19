<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SoutenanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SoutenanceRepository::class)]
#[ApiResource (normalizationContext: ['groups' => ['soutenance:read']])]
class Soutenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['soutenance:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['soutenance:read'])]
    private ?\DateTime $dateHeure = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['soutenance:read'])]
    private ?string $salleOuLien = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    #[Groups(['soutenance:read'])]
    private ?string $noteEntreprise = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    #[Groups(['soutenance:read'])]
    private ?string $noteEnseignant = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['soutenance:read'])]
    private ?string $commentaireJury = null;

    #[ORM\ManyToOne(inversedBy: 'soutenances')]
    private ?Enseignant $enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'soutenances')]
    private ?TuteurPro $tuteurPro = null;

    #[ORM\OneToOne(mappedBy: 'soutenance', cascade: ['persist', 'remove'])]
    #[Groups(['soutenance:read'])]
    private ?Stage $stage = null;

    #[ORM\ManyToOne(inversedBy: 'soutenances')]
    #[Groups(['soutenance:read'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTime
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTime $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getSalleOuLien(): ?string
    {
        return $this->salleOuLien;
    }

    public function setSalleOuLien(?string $salleOuLien): static
    {
        $this->salleOuLien = $salleOuLien;

        return $this;
    }

    public function getNoteEntreprise(): ?string
    {
        return $this->noteEntreprise;
    }

    public function setNoteEntreprise(?string $noteEntreprise): static
    {
        $this->noteEntreprise = $noteEntreprise;

        return $this;
    }

    public function getNoteEnseignant(): ?string
    {
        return $this->noteEnseignant;
    }

    public function setNoteEnseignant(?string $noteEnseignant): static
    {
        $this->noteEnseignant = $noteEnseignant;

        return $this;
    }

    public function getCommentaireJury(): ?string
    {
        return $this->commentaireJury;
    }

    public function setCommentaireJury(?string $commentaireJury): static
    {
        $this->commentaireJury = $commentaireJury;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): static
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getTuteurPro(): ?TuteurPro
    {
        return $this->tuteurPro;
    }

    public function setTuteurPro(?TuteurPro $tuteurPro): static
    {
        $this->tuteurPro = $tuteurPro;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        // unset the owning side of the relation if necessary
        if ($stage === null && $this->stage !== null) {
            $this->stage->setSoutenance(null);
        }

        // set the owning side of the relation if necessary
        if ($stage !== null && $stage->getSoutenance() !== $this) {
            $stage->setSoutenance($this);
        }

        $this->stage = $stage;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }
}
