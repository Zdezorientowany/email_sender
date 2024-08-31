<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName('Users');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Customers');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Employees');
        $manager->persist($category3);

        $manager->flush();

        // referneces for UserFixtures
        $this->addReference('category-users', $category1);
        $this->addReference('category-customers', $category2);
        $this->addReference('category-employees', $category3);
    }
}
