<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class NationalityFixtures extends Fixture
{
    public const NATIONALITY_REFERENCE = 'nationality_';

    public function load(ObjectManager $manager): void
    {
        $nationalities = [
            'Américain', 'Français', 'Turc', 'Espagnol', 'Italien', 'Grec', 'Polonais', 'Colombien'
        ];

        for ($i=0; $i <= 7; $i++) {
            $actor = new Nationality();
            $actor->setNationality($nationalities[$i]);
            $this->addReference(self::NATIONALITY_REFERENCE.$i, $actor);
            $manager->persist($actor);
        }
        $manager->flush();
    }
}
