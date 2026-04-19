<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TuteurProRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Entity\Stage;

#[ORM\Entity(repositoryClass: TuteurProRepository::class)]
#[ApiResource]
class TuteurPro extends Utilisateur
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $fonction = null;

    #[ORM\ManyToOne(inversedBy: 'tuteurPros')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['utilisateur:read', 'stage:read', 'visite:read'])]
    private ?Entreprise $entreprise = null;

    // /**
    //  * @var Collection<int, Creneau>
    //  */
    // #[ORM\OneToMany(targetEntity: Creneau::class, mappedBy: 'tuteurPro')]
    // private Collection $creneaus;

    /**
     * @var Collection<int, Soutenance>
     */
    #[ORM\OneToMany(targetEntity: Soutenance::class, mappedBy: 'tuteurPro')]
    private Collection $soutenances;

    /**
     * @var Collection<int, Stage>
     */
    #[ORM\OneToMany(targetEntity: Stage::class, mappedBy: 'tuteurPro')]
    private Collection $stages;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'tuteurPro')]
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getRoles(): array
    {
        return array_unique([...parent::getRoles(), 'ROLE_TUTEUR_PRO']);
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
    //         $creneau->setTuteurPro($this);
    //     }

    //     return $this;
    // }

    // public function removeCreneau(Creneau $creneau): static
    // {
    //     if ($this->creneaus->removeElement($creneau)) {
    //         // set the owning side to null (unless already changed)
    //         if ($creneau->getTuteurPro() === $this) {
    //             $creneau->setTuteurPro(null);
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
            $soutenance->setTuteurPro($this);
        }

        return $this;
    }

    public function removeSoutenance(Soutenance $soutenance): static
    {
        if ($this->soutenances->removeElement($soutenance)) {
            // set the owning side to null (unless already changed)
            if ($soutenance->getTuteurPro() === $this) {
                $soutenance->setTuteurPro(null);
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
            $stage->setTuteurPro($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): static
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getTuteurPro() === $this) {
                $stage->setTuteurPro(null);
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
            $visite->setTuteurPro($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getTuteurPro() === $this) {
                $visite->setTuteurPro(null);
            }
        }

        return $this;
    }
}
