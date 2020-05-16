<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    
    protected function loadData(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Admin 1');
        $user->setRole(User::ROLE_ADMIN);
        $user->setPassword('password_1');
        $manager->persist($user);
        $this->addReference(User::class . '_' . 1, $user);
        $user = new User();
        $user->setName('Admin 2');
        $user->setRole(User::ROLE_ADMIN);
        $user->setPassword('password_2');
        $manager->persist($user);
        $this->addReference(User::class . '_' . 2, $user);
        $user = new User();
        $user->setName('Benutzer 3');
        $user->setRole(User::ROLE_USER);
        $user->setPassword('password_3');
        $manager->persist($user);
        $this->addReference(User::class . '_' . 3, $user);
        $user = new User();
        $user->setName('Benutzer 4');
        $user->setRole(User::ROLE_USER);
        $user->setPassword('password_4');
        $manager->persist($user);
        $this->addReference(User::class . '_' . 4, $user);
        $user = new User();
        $user->setName('Benutzer 5');
        $user->setRole(User::ROLE_USER);
        $user->setPassword('password_5');
        $manager->persist($user);
        $this->addReference(User::class . '_' . 5, $user);
        $manager->flush();
    }
}
