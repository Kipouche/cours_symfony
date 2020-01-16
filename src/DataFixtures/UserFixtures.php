<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $count = 0;
        $info=[
            "user@yopmail.com" => [],
            "user2@yopmail.com" => [],
            "author@yopmail.com" => ["ROLE_AUTHOR"],
            "author2@yopmail.com" => ["ROLE_AUTHOR"],
            "admin@yopmail.com" => ["ROLE_ADMIN"],
        ];

        foreach ($info as $email=>$role){
            $user = new User();
            $user->setLastName($faker->lastName());
            $user->setFirstName($faker->firstName());
            $user->setEmail($email);
            $user->setRoles($role);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "azertyuiop"));
            $manager->persist($user);

            if(\in_array("ROLE_AUTHOR", $role)){
                $this->addReference('USER'.$count, $user);
                $count++;
            }
        }

        $manager->flush();
    }
}
