<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Faker\Factory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public const MOVIE_REFERENCE = 'movie_';
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($this->faker));

        for ($i = 1; $i <= 100; $i++) {
            $movie = new Movie();
            $movie->setTitle($this->faker->movie)
                ->setCategory($this->getReference(CategoryFixtures::CAT_REFERENCE . rand(1, 5)))
                ->setOwner($this->getReference(UserFixtures::USER_REFERENCE . rand(1, 6)))
                ->setDescription($this->faker->realText(255))
                ->setDuration(rand(80, 250))
                ->setReleaseDate($this->faker->dateTimeBetween('-30 years', 'now'))
                ->setPoster('/images/movie' . $i . '.jpg');
            $this->addReference(self::MOVIE_REFERENCE . $i, $movie);

            $actors = [];
            for ($j = 0; $j <= rand(2, 8); $j++) {
                $actor = $this->getReference(ActorFixtures::ACTOR_REFERENCE . rand(0, 20));
                if (!in_array($actor, $actors)) {
                    $actors[] = $actor;
                    $movie->addActor($actor);
                }
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ActorFixtures::class,
            UserFixtures::class
        ];
    }
}
