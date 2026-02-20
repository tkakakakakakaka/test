<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
         $usersData = [
            [
                'email' => 'admin@gmail.com',
                'ssn' => '176168190198121',
                'prenom' => 'admin',
                'nom' => 'admin',
                'genre' => 'homme',
                'role' => 'ROLE_ADMIN'
            ],
            [
                'email' => 'medecin@gmail.com',
                'ssn' => '671351678901245',
                'prenom' => 'medecin',
                'nom' => 'medecin',
                'genre' => 'femme',
                'role' => 'ROLE_MEDECIN'
            ],
            [
                'email' => 'patient@gmail.com',
                'ssn' => '915681013466172',
                'prenom' => 'patient',
                'nom' => 'patient',
                'genre' => 'homme',
                'role' => 'ROLE_PATIENT'
            ],
            [
                'email' => 'patient2@gmail.com',
                'ssn' => '718451999167871',
                'prenom' => 'patient2',
                'nom' => 'patient2',
                'genre' => 'homme',
                'role' => 'ROLE_PATIENT'
            ],
            [
                'email' => 'patient3@gmail.com',
                'ssn' => '111222333444555',
                'prenom' => 'patient3',
                'nom' => 'patient3',
                'genre' => 'homme',
                'role' => 'ROLE_PATIENT'
            ],
            [
                'email' => 'patient4@gmail.com',
                'ssn' => '222111333444666',
                'prenom' => 'patient4',
                'nom' => 'patient4',
                'genre' => 'femme',
                'role' => 'ROLE_PATIENT'
            ],
            [
                'email' => 'patient5@gmail.com',
                'ssn' => '999888111222555',
                'prenom' => 'patient5',
                'nom' => 'patient5',
                'genre' => 'femme',
                'role' => 'ROLE_PATIENT'
            ],
        ];

        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data['email'])
                 ->setSsn($data['ssn'])
                 ->setPrenom($data['prenom'])
                 ->setNom($data['nom'])
                 ->setGenre($data['genre'])
                 ->setRoles([$data['role']]);

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'azerty');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
