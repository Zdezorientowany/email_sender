<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private const TOTAL_USERS = 10;
    private const CUSTOMERS_COUNT = 7;
    private const EMPLOYEES_COUNT = 3;

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::TOTAL_USERS; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail($faker->unique()->email);

            $user->addCategory($this->getReference('category-users'));

            if ($i < self::CUSTOMERS_COUNT) {
                $user->addCategory($this->getReference('category-customers'));
            }

            if ($i < self::EMPLOYEES_COUNT) {
                $user->addCategory($this->getReference('category-employees'));
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
