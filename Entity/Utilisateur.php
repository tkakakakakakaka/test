<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['enseignant' => Enseignant::class,
                        'etudiant' => Etudiant::class,
                        'tuteur_pro' => TuteurPro::class,
                        'directeur' => Directeur::class,])]
#[ApiResource(normalizationContext: ['groups'=> ['utilisateur:read']], denormalizationContext: ['groups'=> ['utilisateur:write']])]
abstract class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups (['utilisateur:read', 'utilisateur:write', 'stage:read', 'soutenance:read', 'visite:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups (['utilisateur:read', 'utilisateur:write', 'stage:read', 'soutenance:read', 'visite:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups (['utilisateur:read', 'utilisateur:write', 'stage:read', 'soutenance:read', 'visite:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    #[Groups (['utilisateur:read', 'utilisateur:write', 'stage:read', 'soutenance:read', 'visite:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column]
    private ?bool $estAdmin = null;

    #[ORM\Column]
    private ?bool $estSecretaire = null;

    #[ORM\Column]
    private ?bool $compteBloque = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function isEstAdmin(): ?bool
    {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): static
    {
        $this->estAdmin = $estAdmin;

        return $this;
    }

    public function isEstSecretaire(): ?bool
    {
        return $this->estSecretaire;
    }

    public function setEstSecretaire(bool $estSecretaire): static
    {
        $this->estSecretaire = $estSecretaire;

        return $this;
    }

    public function isCompteBloque(): ?bool
    {
        return $this->compteBloque;
    }

    public function setCompteBloque(bool $compteBloque): static
    {
        if ($compteBloque && $this->estAdmin){
            throw new \LogicException('Un administrateur ne peux pas bloquer son propre compte.');
        }
        $this->compteBloque = $compteBloque;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    #[Groups(['utilisateur:read'])]
    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];
        if ($this->estAdmin)
            $roles[] = 'ROLE_ADMIN';
        if ($this->estSecretaire)
            $roles[] = 'ROLE_SECRETAIRE';
        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return (string) $this->mdp;
    }

    public function eraseCredentials(): void{}
}
