<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{

    public const MOVIE_REFERENCE = 'movie_';

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 30; $i++) {
            $movie = new Movie();
            $movie->setTitle('Movie'.$i)
                ->setCategory($this->getReference(CategoryFixtures::CAT_REFERENCE.rand(1, 5)))
                ->setDescription('Description movie'.$i)
                ->setDuration(rand(80, 250))
                ->setReleaseDate(new \DateTime('now'));
            $this->addReference(self::MOVIE_REFERENCE.$i, $movie);

            $actors = [];
            for($j=0; $j <= rand(2,7); $j++)
            {
                $actor = $this->getReference(ActorFixtures::ACTOR_REFERENCE.rand(0,10));
                if (!in_array($actor, $actors))
                {
                    $actors[] = $actor;
                    $movie->addActor($actor);
                }
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            CategoryFixtures::class,
            ActorFixtures::class
        ];
    }
}
