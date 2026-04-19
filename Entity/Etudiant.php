<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ApiResource]
class Etudiant extends Utilisateur
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['utilisateur:read', 'stage:read', 'soutenance:read', 'visite:read'])]
    private ?string $numEtudiant = null;

    // /**
    //  * @var Collection<int, Creneau>
    //  */
    // #[ORM\OneToMany(targetEntity: Creneau::class, mappedBy: 'etudiant')]
    // private Collection $creneaus;

    /**
     * @var Collection<int, Stage>
     */
    #[ORM\OneToMany(targetEntity: Stage::class, mappedBy: 'etudiant')]
    private Collection $stages;

    /**
     * @var Collection<int, Soutenance>
     */
    #[ORM\OneToMany(targetEntity: Soutenance::class, mappedBy: 'etudiant')]
    private Collection $soutenances;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'etudiant')]
    private Collection $visites;

    public function __construct()
    {
        // $this->creneaus = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->soutenances = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getNumEtudiant(): ?string
    {
        return $this->numEtudiant;
    }

    public function setNumEtudiant(?string $numEtudiant): static
    {
        $this->numEtudiant = $numEtudiant;

        return $this;
    }

    public function getRoles(): array
    {
        return array_unique([...parent::getRoles(), 'ROLE_ETUDIANT']);
    }

    // /**
    //  * @return Collection<int, Creneau>
    //  */
    // public function getCreneaus(): Collection
    // {
    //     return $this->creneaus;
    // }

    // public function addCreneau(Creneau $creneau): static
    // {
    //     if (!$this->creneaus->contains($creneau)) {
    //         $this->creneaus->add($creneau);
    //         $creneau->setEtudiant($this);
    //     }

    //     return $this;
    // }

    // public function removeCreneau(Creneau $creneau): static
    // {
    //     if ($this->creneaus->removeElement($creneau)) {
    //         // set the owning side to null (unless already changed)
    //         if ($creneau->getEtudiant() === $this) {
    //             $creneau->setEtudiant(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): static
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
            $stage->setEtudiant($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): static
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEtudiant() === $this) {
                $stage->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Soutenance>
     */
    public function getSoutenances(): Collection
    {
        return $this->soutenances;
    }

    public function addSoutenance(Soutenance $soutenance): static
    {
        if (!$this->soutenances->contains($soutenance)) {
            $this->soutenances->add($soutenance);
            $soutenance->setEtudiant($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): static
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getEtudiant() === $this) {
                $soutenance->setEtudiant(null);
            }
        }

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
            $visite->setEtudiant($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getEtudiant() === $this) {
                $visite->setEtudiant(null);
            }
        }

        return $this;
    }
}
