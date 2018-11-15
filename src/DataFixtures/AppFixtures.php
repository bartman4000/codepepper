<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product = new Product('TSHIRT0011', 120);
        $manager->persist($product);

        $product = new Product('CARTOYR0200', 300);
        $manager->persist($product);

        $product = new Product('CARTOYW0201', 320);
        $manager->persist($product);

        $manager->flush();
    }
}
