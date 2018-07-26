<?php

namespace App\Controller;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends AbstractController
{
//    /**
//     * @Route("/index", name="index")
//     */
    public function index()
    {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $page = new Page();
//        $page->setTitle('Keyboard2');
//        $page->setBody('article the first2');
//        $page->setCategory('news');
//
//        // tell Doctrine you want to (eventually) save the Product (no queries yet)
//        $entityManager->persist($page);
//
//        // actually executes the queries (i.e. the INSERT query)
//        $entityManager->flush();
//
//        return new Response('Saved new product with id '.$page->getId());
    }

//    /**
//     * @Route("page/{id}", name="page")
//     */
    public  function show(Page $page)
    {
//        $page = $this->getDoctrine()
//            ->getRepository(Page::class)
//            ->find($id);
//
//        if (!$page) {
//            throw $this->createNotFoundException(
//                'No article found for id '.$id
//            );
//        }

//        return new Response('Check out this great article: '.$page->getTitle());

    }
}
