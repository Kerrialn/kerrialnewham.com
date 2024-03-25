<?php

namespace App\Controller\Controller;

use App\Repository\ArticleRepository;
use App\Repository\VentureRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly VentureRepository $ventureRepository,
        private readonly PaginatorInterface $paginator
    )
    {
    }

    #[Route('/', name: 'landing')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findRecentlyPublished();
        return $this->render('app/ladning.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('app/contact.html.twig');
    }


    #[Route('/currently', name: 'currently')]
    public function currently(): Response
    {

        $venturesQuery = $this->ventureRepository->findByCreatedAt(isQuery: true);
        $venturesPagination = $this->paginator->paginate(
            target: $venturesQuery,
            limit: 20
        );

        return $this->render('app/currently.html.twig', [
            'venturesPagination' => $venturesPagination
        ]);
    }


}