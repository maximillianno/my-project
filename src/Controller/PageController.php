<?php

namespace App\Controller;

use App\Entity\Page;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @Route("/pages", name="pages")
     */
    public function index()
    {
        $pageRepo = $this->getDoctrine()
            ->getRepository(Page::class);
        $pages = $pageRepo->findAll();



        return $this->render('page/list.html.twig', [
            'pages' => $pages,
        ]);
    }

    /**
     * @Route("/page/{id}", name="page")
     */
    public function show(Page $page)
    {
//        $page = $this->getDoctrine()
//            ->getRepository(Page::class)
//            ->find($id);

        return $this->render('page/show.html.twig', [
            'page' => $page

        ]);
    }
}
