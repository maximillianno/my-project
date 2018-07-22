<?php

namespace App\DataFixtures;


use App\Entity\Term;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TermLoad extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 3; $i++) {
            $product = new Term();
            $product->setName('category '.$i);
            $product->setDescription('category number '. $i);
            $manager->persist($product);
        }
        $manager->flush();
    }

}
