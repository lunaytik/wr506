<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public const CAT_REFERENCE = 'cat_';
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($this->faker));

        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName($this->faker->movieGenre);
            $this->addReference(self::CAT_REFERENCE . $i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
