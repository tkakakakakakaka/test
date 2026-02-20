<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ConsultationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        
        for ($i = 0; $i < 50; $i++) {
            $consultation = new Consultation();
            $consultation->setAge($faker->numberBetween(10, 90));
            $consultation->setDescription($faker->paragraph());
            $consultation->setDate($faker->dateTimeBetween('-1 years', 'now') );

            $manager->persist($consultation);
        }

        $manager->flush();
    }
}
