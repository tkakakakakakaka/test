<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ApiResource]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['stage:read', 'visite:read'])]
    private ?string $raisonSociale = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 100)]
    #[Groups(['visite:read'])]
    private ?string $secteurActivite = null;

    /**
     * @var Collection<int, TuteurPro>
     */
    #[ORM\OneToMany(targetEntity: TuteurPro::class, mappedBy: 'entreprise')]
    private Collection $tuteurPros;

    public function __construct()
    {
        $this->tuteurPros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): static
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSecteurActivite(): ?string
    {
        return $this->secteurActivite;
    }

    public function setSecteurActivite(string $secteurActivite): static
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    /**
     * @return Collection<int, TuteurPro>
     */
    public function getTuteurPros(): Collection
    {
        return $this->tuteurPros;
    }

    public function addTuteurPro(TuteurPro $tuteurPro): static
    {
        if (!$this->tuteurPros->contains($tuteurPro)) {
            $this->tuteurPros->add($tuteurPro);
            $tuteurPro->setEntreprise($this);
        }

        return $this;
    }

    public function removeTuteurPro(TuteurPro $tuteurPro): static
    {
        if ($this->tuteurPros->removeElement($tuteurPro)) {
            // set the owning side to null (unless already changed)
            if ($tuteurPro->getEntreprise() === $this) {
                $tuteurPro->setEntreprise(null);
            }
        }

        return $this;
    }
}
