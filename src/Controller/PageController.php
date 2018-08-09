<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Form\SearchType;
use App\Repository\CommentRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="page_index", methods="GET")
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', ['pages' => $pageRepository->findAll()]);
    }

    /**
     * @Route("/{id}/comments/", name="page_comments", methods="GET")
     */
    public function comments(Page $page, CommentRepository $commentRepository): Response
    {
        //Количество комментариев последних
        $limit = 3;
        return $this->render('comment/page_comments.html.twig', [
            'comments' => $commentRepository->findLastComments($page,$limit)
        ]);
    }

    /**
     * @Route("/search/", name="search", methods="GET|POST")
     */
    public function search(PageRepository $pageRepository, Request $request){
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $result = [];
        if ($form->isSubmitted()){
            $data = $form->getData();
            $result = $pageRepository->findWord($data['search']);

        }
//        return $this->render('page/index.html.twig',['pages' => $result]);

        return $this->render('page/search.html.twig', ['form' => $form->createView(), 'pages' => $result]);



    }

    /**
     * @Route("/new", name="page_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);

        //заполняет сущность Page
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();


            return $this->redirectToRoute('page_index');
        }
//        dd($form->createView());

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(Page $page): Response
    {
        //$firstComment = $this->getDoctrine()->getRepository('App:Comment')->findLastComments($page);



        return $this->render('piccolo/show.html.twig', [
            'page' => $page,
//            'first_comment' => $firstComment[0]
        ]);
    }

    /**
     * @Route("/{id}/edit", name="page_edit", methods="GET|POST")
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($this->getDoctrine()->getManager());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page_edit', ['id' => $page->getId()]);
        }



        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="page_delete", methods="DELETE")
     */
    public function delete(Request $request, Page $page): Response
    {
//        dd($page->getComments());
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('page_index');
    }
}
