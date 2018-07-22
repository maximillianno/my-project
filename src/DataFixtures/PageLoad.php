<?php

namespace App\DataFixtures;


use App\Entity\Page;
use App\Entity\Term;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PageLoad extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $termRepo = $manager->getRepository(Term::class);
        for ($i = 0; $i < 3; $i++) {
            $product = new Page();
            $product->setTitle('article '.$i);
            $product->setBody('article number '. $i);
            $term = $termRepo->findOneByName('category '.$i);
            if ($term){
                $product->setCategory($term);
            }

            $manager->persist($product);
        }
        $manager->flush();

    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [
            TermLoad::class,
        ];
    }
}
