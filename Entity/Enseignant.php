<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;
#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
#[ApiResource]
class Enseignant extends Utilisateur
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['utilisateur:read', 'stage:read'])]
    private ?string $matricule = null;

    // /**
    //  * @var Collection<int, Creneau>
    //  */
    // #[ORM\OneToMany(targetEntity: Creneau::class, mappedBy: 'enseignant')]
    // private Collection $creneaus;

    /**
     * @var Collection<int, Soutenance>
     */
    #[ORM\OneToMany(targetEntity: Soutenance::class, mappedBy: 'enseignant')]
    private Collection $soutenances;

    /**
     * @var Collection<int, Stage>
     */
    #[ORM\OneToMany(targetEntity: Stage::class, mappedBy: 'enseignant')]
    private Collection $stages;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'enseignant')]
    private Collection $visites;

    public function __construct()
    {
        // $this->creneaus = new ArrayCollection();
        $this->soutenances = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getRoles(): array
    {
        return array_unique([...parent::getRoles(), 'ROLE_ENSEIGNANT']);
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
    //         $creneau->setEnseignant($this);
    //     }

    //     return $this;
    // }

    // public function removeCreneau(Creneau $creneau): static
    // {
    //     if ($this->creneaus->removeElement($creneau)) {
    //         // set the owning side to null (unless already changed)
    //         if ($creneau->getEnseignant() === $this) {
    //             $creneau->setEnseignant(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $soutenance->setEnseignant($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): static
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getEnseignant() === $this) {
                $soutenance->setEnseignant(null);
            }
        }

        return $this;
    }

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
            $stage->setEnseignant($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): static
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEnseignant() === $this) {
                $stage->setEnseignant(null);
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
            $visite->setEnseignant($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getEnseignant() === $this) {
                $visite->setEnseignant(null);
            }
        }

        return $this;
    }
}
