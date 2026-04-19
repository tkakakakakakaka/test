<?php

namespace App\Entity;

use App\Enum\StatutStage;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\StageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: StageRepository::class)]
#[ApiResource(
    normalizationContext: ["groups"=> ["stage:read"]],
    denormalizationContext: ["groups"=> ["stage:write"]],
    operations: [
        new GetCollection(),
        new Get(),
        new Post(security: "is_granted('WRITE_ACCESS', user)"),
        new Put(security: "is_granted('WRITE_ACCESS', user)"),
        new Patch(security: "is_granted('WRITE_ACCESS', user)"),
        new Delete(security: "is_granted('ROLE_ADMIN')"),
    ]
)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['stage:read', 'stage:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?\DateTime $dateDeb = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?\DateTime $dateFin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?string $remuneration = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?string $nomRh = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?string $contactRh = null;

    #[ORM\Column(type: 'string', enumType: StatutStage::class)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?StatutStage $statutValidation = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['stage:read', 'stage:write'])]
    private ?int $anneeStage = null;

    #[ORM\Column]
    #[Groups(['stage:read', 'stage:write'])]
    private ?bool $estOptionnel = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[Groups(['stage:read', 'stage:write'])]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[Groups(['stage:read', 'stage:write'])]
    private ?Enseignant $enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[Groups(['stage:read', 'stage:write'])]
    private ?TuteurPro $tuteurPro = null;

    #[ORM\OneToOne(inversedBy: 'stage', cascade: ['persist', 'remove'])]
    private ?Soutenance $soutenance = null;

    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'stage')]
    private Collection $visites;

    public function __construct()
    {
        $this->visites = new ArrayCollection();
        $this->statutValidation = StatutStage::PROPOSE;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(?string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDateDeb(): ?\DateTime
    {
        return $this->dateDeb;
    }

    public function setDateDeb(?\DateTime $dateDeb): static
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getRemuneration(): ?string
    {
        return $this->remuneration;
    }

    public function setRemuneration(?string $remuneration): static
    {
        $this->remuneration = $remuneration;

        return $this;
    }

    public function getNomRh(): ?string
    {
        return $this->nomRh;
    }

    public function setNomRh(?string $nomRh): static
    {
        $this->nomRh = $nomRh;

        return $this;
    }

    public function getContactRh(): ?string
    {
        return $this->contactRh;
    }

    public function setContactRh(?string $contactRh): static
    {
        $this->contactRh = $contactRh;

        return $this;
    }

    public function getStatutValidation(): ?StatutStage
    {
        return $this->statutValidation;
    }

    public function setStatutValidation(StatutStage $statutValidation): static
    {
        $this->statutValidation = $statutValidation;

        return $this;
    }

    public function getAnneeStage(): ?int
    {
        return $this->anneeStage;
    }

    public function setAnneeStage(?int $anneeStage): static
    {
        $this->anneeStage = $anneeStage;

        return $this;
    }

    public function isEstOptionnel(): ?bool
    {
        return $this->estOptionnel;
    }

    public function setEstOptionnel(bool $estOptionnel): static
    {
        $this->estOptionnel = $estOptionnel;

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

    public function getTuteurPro(): ?TuteurPro
    {
        return $this->tuteurPro;
    }

    public function setTuteurPro(?TuteurPro $tuteurPro): static
    {
        $this->tuteurPro = $tuteurPro;

        return $this;
    }

    public function getSoutenance(): ?Soutenance
    {
        return $this->soutenance;
    }

    public function setSoutenance(?Soutenance $soutenance): static
    {
        $this->soutenance = $soutenance;

        return $this;
    }

    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setStage($this);
        }
        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            if ($visite->getStage() === $this) {
                $visite->setStage(null);
            }
        }
        return $this;
    }
}
