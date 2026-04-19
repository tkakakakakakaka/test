<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: CreneauRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: '/creneaux'),
        new Get(uriTemplate: '/creneaux/{id}'),
        new Post(uriTemplate: '/creneaux'),
        new Patch(uriTemplate: '/creneaux/{id}'),
        new Delete(uriTemplate: '/creneaux/{id}'),
    ]
)]
class Creneau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateJour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $heureFin = null;

    // #[ORM\ManyToOne(inversedBy: 'creneaus')]
    // private ?Enseignant $enseignant = null;

    // #[ORM\ManyToOne(inversedBy: 'creneaus')]
    // private ?Etudiant $etudiant = null;

    // #[ORM\ManyToOne(inversedBy: 'creneaus')]
    // private ?TuteurPro $tuteurPro = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'creneau')]
    private Collection $visites;

    public function __construct()
    {
        $this->visites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateJour(): ?\DateTime
    {
        return $this->dateJour;
    }

    public function setDateJour(\DateTime $dateJour): static
    {
        $this->dateJour = $dateJour;

        return $this;
    }

    public function getHeureDebut(): ?\DateTime
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTime $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTime
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTime $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    // public function getEnseignant(): ?Enseignant
    // {
    //     return $this->enseignant;
    // }

    // public function setEnseignant(?Enseignant $enseignant): static
    // {
    //     $this->enseignant = $enseignant;

    //     return $this;
    // }

    // public function getEtudiant(): ?Etudiant
    // {
    //     return $this->etudiant;
    // }

    // public function setEtudiant(?Etudiant $etudiant): static
    // {
    //     $this->etudiant = $etudiant;

    //     return $this;
    // }

    // public function getTuteurPro(): ?TuteurPro
    // {
    //     return $this->tuteurPro;
    // }

    // public function setTuteurPro(?TuteurPro $tuteurPro): static
    // {
    //     $this->tuteurPro = $tuteurPro;

    //     return $this;
    // }

    public function getUtilisateur(): ?Utilisateur{
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static{
        $this->utilisateur = $utilisateur;
        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setCreneau($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getCreneau() === $this) {
                $visite->setCreneau(null);
            }
        }

        return $this;
    }
}
