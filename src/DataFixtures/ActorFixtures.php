<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const ACTOR_REFERENCE = 'actor_';

    public function load(ObjectManager $manager): void
    {
        $firstNames = [
            'John', 'Jane', 'Johnny', 'Joe', 'Jose', 'Jacques', 'Marie', 'Jean-Louis'
        ];

        $lastNames = [
            'Doe', 'Dupont', 'Pearce', 'Duc', 'Prince', 'Rock'
        ];

        for ($i=0; $i <= 10; $i++) {
            $actor = new Actor();
            $actor->setFirstName($firstNames[rand(0,(count($firstNames)-1))]);
            $actor->setLastName($lastNames[rand(0,(count($lastNames)-1))]);
            $actor->setNationality($this->getReference(NationalityFixtures::NATIONALITY_REFERENCE.rand(0,7)));
            $this->addReference(self::ACTOR_REFERENCE.$i, $actor);
            $manager->persist($actor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          NationalityFixtures::class
        ];
    }
}
