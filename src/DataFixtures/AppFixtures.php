<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }



    public function load(ObjectManager $manager): void
    {
 $user1 = new User();
        $user1->setEmail('test@test.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('john@test.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                '12345678'
            )
        );
        $manager->persist($user2);



        $MicroPost1 = new MicroPost();
        $MicroPost1->setTitle('Welcome to Tenerife!');
        $MicroPost1->setText('Have a happy holiday!');
        $MicroPost1->setCreated(new DateTime());
        $manager->persist($MicroPost1);

        $MicroPost2 = new MicroPost();
        $MicroPost2->setTitle('Welcome to Finland!');
        $MicroPost2->setText('Have a happy winterholiday!');
        $MicroPost2->setCreated(new DateTime());
        $manager->persist($MicroPost2);

        $MicroPost3 = new MicroPost();
        $MicroPost3->setTitle('It was a pleasure!');
        $MicroPost3->setText('Welcome back!');
        $MicroPost3->setCreated(new DateTime());
        $manager->persist($MicroPost3);

        // Flush for executing this query
        $manager->flush();
    }
}
