<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Page;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/", name="comment_index", methods="GET")
     */
    public function index(CommentRepository $commentRepository): Response
    {

        //Текущая страница
        $page = $this->get('request_stack')->getCurrentRequest()->query->get('page') ? $this->get('request_stack')->getCurrentRequest()->query->get('page') : 1;



        //Адаптер для работы с БД через доктрин
        $queryBuilder = $commentRepository->createQueryBuilder('c');
        $adapter = new DoctrineORMAdapter($queryBuilder);
        //$adapter = new ArrayAdapter($commentRepository->findAll()); - получает все записи, а потом работает


        $pagerfanta = new Pagerfanta($adapter);

        //TODO: вынести в настройки потом
        $pagerfanta->setMaxPerPage(3);
        $pagerfanta->setCurrentPage($page);
        //Количество общее
        $nbResults = $pagerfanta->getNbResults();

        $currentPageResults = $pagerfanta->getCurrentPageResults();





//        dd($countcom);
//        return $this->render('comment/index.html.twig', ['comments' => $commentRepository->findAll(), 'countcom' => $countcom[1]]);
        return $this->render('comment/index.html.twig', ['comments' => $currentPageResults,  'my_pager' => $pagerfanta]);

    }

    /**
     * @Route("/new", name="comment_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods="GET")
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', ['comment' => $comment]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods="GET|POST")
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', ['id' => $comment->getId()]);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods="DELETE")
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }
}
