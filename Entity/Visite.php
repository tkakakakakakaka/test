<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['visite:read']],
)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visite:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['visite:read'])]
    private ?\DateTime $dateVisite = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['visite:read'])]
    private ?string $compteRendu = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['visite:read'])]
    private ?string $listePresence = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    #[Groups(['visite:read'])]
    private mixed $singatureNum = null;

    #[ORM\ManyToOne(inversedBy:"visites")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visite:read'])]
    private ?Stage $stage = null;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    #[Groups(['visite:read'])]
    private ?TuteurPro $tuteurPro = null;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    #[Groups(['visite:read'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    #[Groups(['visite:read'])]
    private ?Enseignant $enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    #[Groups(['visite:read'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creneau $creneau = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTime
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTime $dateVisite): static
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getCompteRendu(): ?string
    {
        return $this->compteRendu;
    }

    public function setCompteRendu(?string $compteRendu): static
    {
        $this->compteRendu = $compteRendu;

        return $this;
    }

    public function getListePresence(): ?string
    {
        return $this->listePresence;
    }

    public function setListePresence(?string $listePresence): static
    {
        $this->listePresence = $listePresence;

        return $this;
    }

    public function getSingatureNum(): mixed
    {
        return $this->singatureNum;
    }

    public function setSingatureNum(mixed $singatureNum): static
    {
        $this->singatureNum = $singatureNum;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;

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

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

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

    public function getCreneau(): ?Creneau
    {
        return $this->creneau;
    }

    public function setCreneau(?Creneau $creneau): static
    {
        $this->creneau = $creneau;

        return $this;
    }
}
