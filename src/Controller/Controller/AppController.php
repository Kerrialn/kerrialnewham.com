<?php

namespace App\Controller\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    public function __construct(
        private readonly ArticleRepository $articleRepository
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
        return $this->render('app/currently.html.twig');
    }


}