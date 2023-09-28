<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user_';

    public function __construct(protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 6; $i++) {
            $roles = ['ROLE_USER'];

            $i == 1 ? $roles[] = 'ROLE_ADMIN' : null;

            $user = new User();
            $user->setEmail('email'.$i.'@test.com')
                ->setPassword($this->passwordHasher->hashPassword($user, 'test'))
                ->setRoles($roles);
            $this->addReference(self::USER_REFERENCE.$i, $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
