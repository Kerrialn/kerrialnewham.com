<?php

namespace App\Controller\Controller;

use App\DataTransferObject\ArticleFilterDto;
use App\Entity\Article;
use App\Form\Filter\ArticleFilter;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly PaginatorInterface $paginator,
    )
    {
    }

    #[Route('/articles', name: 'articles')]
    public function index(Request $request): Response
    {
        $articleFilterDto = new ArticleFilterDto();
        $articleFilter = $this->createForm(ArticleFilter::class, $articleFilterDto);

        $articlesQuery = $this->articleRepository->findRecentlyPublished(isQuery: true);
        $articlesInitPagination = $this->paginator->paginate(
            target: $articlesQuery,
            limit: 20
        );

        $articleFilter->handleRequest($request);
        if ($articleFilter->isSubmitted() && $articleFilter->isValid()) {

            $articlesQuery = $this->articleRepository->findByFilter(articleFilterDto: $articleFilterDto, isQuery: true);
            $articlesPagination = $this->paginator->paginate(
                target: $articlesQuery,
                page: $request->query->getInt('page', 1),
                limit: 20
            );

            return $this->render('articles/index.html.twig', [
                'articlesPagination' => $articlesPagination,
                'articleFilter' => $articleFilter,
            ]);
        }

        return $this->render('articles/index.html.twig', [
            'articlesPagination' => $articlesInitPagination,
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
        $moreArticles = $this->articleRepository->findOtherArticles($article->getId());

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'moreArticles' => $moreArticles,
        ]);

    }
}