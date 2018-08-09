<?php

namespace App\Controller;

use App\Entity\Term;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
//    /**
//     * @Route("/block", name="block")
//     */
//    public function index()
//    {
//        return $this->render('block/index.html.twig', [
//            'controller_name' => 'BlockController',
//        ]);
//    }

    //Конкретные блоки, шаблоны которых в Piccolo
    //preview - index шаблон
    //page - главный макет
    //nav - макет навигации
    //block - макет мелких блоков


    //Рендер лого
    public function logoAction(){
        return $this->render('block/logo.html.twig');
    }
    public function mainMenuAction(){
        return $this->render('block/menu.html.twig');
    }
    public function mainMenuFooterAction(){
        return $this->render('block/menu-footer.html.twig');
    }
    public function categoryAction(){
        $terms = $this->getDoctrine()->getRepository(Term::class)->findAll();
        return $this->render('block/category-list.html.twig', [ 'terms' => $terms]);
    }

}
