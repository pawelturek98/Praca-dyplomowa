<?php

declare(strict_types=1);

namespace App\DataFixtures\User;

use App\DataFixtures\AppFixtures;
use App\Dictionary\UserManagement\UserDictionary;
use App\Entity\UserManagement\User;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends AppFixtures
{
    private const DATA = [
        [
            'username' => 'student1',
            'email' => 'student1@example.com',
            'password' => 'student1Password',
            'role' => UserDictionary::ROLE_STUDENT,
        ],
        [
            'username' => 'student2',
            'email' => 'student2@example.com',
            'password' => 'student2Password',
            'role' => UserDictionary::ROLE_STUDENT,
        ],
        [
            'username' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => 'teacherPassword',
            'role' => UserDictionary::ROLE_TEACHER,
        ],
        [
            'username' => 'administrator',
            'email' => 'administrator@example.com',
            'password' => 'administratorPassword',
            'role' => UserDictionary::ROLE_ADMINISTRATOR,
        ],
    ];

    private Generator $faker;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $user) {
            $this->createUser($manager, $user);
        }

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, array $userData): void
    {
        $user = (new User())
            ->setUsername($userData['username'])
            ->setEmail($userData['email'])
            ->setType($userData['role'])
            ->setFirstname($this->faker->firstName)
            ->setLastname($this->faker->lastName)
        ;

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $userData['password'])
        );

        $manager->persist($user);
    }
}
