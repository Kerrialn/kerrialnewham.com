<?php

namespace App\Controller\Controller;

use App\DataTransferObject\ArticleFilterDto;
use App\Entity\Article;
use App\Form\Filter\ArticleFilter;
use App\Repository\ArticleRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    )
    {
    }

    #[Route('/articles', name: 'articles')]
    public function index(Request $request): Response
    {
        $articleFilterDto = new ArticleFilterDto();
        $articleFilter = $this->createForm(ArticleFilter::class, $articleFilterDto);

        $articles = $this->articleRepository->findRecentlyPublished();

        $articleFilter->handleRequest($request);
        if ($articleFilter->isSubmitted() && $articleFilter->isValid()) {
            $articles = $this->articleRepository->findByFilter(articleFilterDto: $articleFilterDto);

            return $this->render('articles/index.html.twig', [
                'articles' => $articles,
                'articleFilter' => $articleFilter,
            ]);
        }

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'articleFilter' => $articleFilter,
        ]);

    }

    #[Route('/articles/{slug}', name: 'article')]
    public function show(
        #[MapEntity(mapping: [
            'slug' => 'slug',
        ])]
        Article $article
    ): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);

    }
}