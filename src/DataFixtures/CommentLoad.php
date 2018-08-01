<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentLoad extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $pageRepo = $manager->getRepository(Page::class);
        $pages = $pageRepo->findAll();
        foreach ($pages as $page) {
            for ($i = 1; $i < 3; $i++){
                $comment = new Comment();
                $comment->setComment('comment '.$i);
                $page->addComment($comment);
                $manager->persist($comment);
            }
            $manager->persist($page);
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
        return [PageLoad::class];
    }
}
