<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class CategoryFixtures extends Fixture
{
    public const CAT_REFERENCE = 'cat_';

    public function load(ObjectManager $manager): void
    {

        for ($i=1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('Category'.$i);
            $this->addReference(self::CAT_REFERENCE.$i, $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
