<?php

namespace App\Controller\Controller;

use App\Model\Quote;
use App\Repository\ArticleRepository;
use App\Repository\VentureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    public function __construct(
        private readonly ArticleRepository  $articleRepository,
        private readonly VentureRepository  $ventureRepository,
        private readonly PaginatorInterface $paginator,
    )
    {
    }

    #[Route('/', name: 'landing')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findRecentlyPublished();

        $quotes = [
            new Quote(quote: 'That\'s all any of us are: amateurs. we don\'t live long enough to be anything else.', author: 'Charlie Chaplin'),
            new Quote(quote: 'Pull back the curtain on your process', author: 'Ann Friedman'),
            new Quote(quote: 'This is the true joy in life, being used for a purpose recognized by yourself as a mighty one. Being a force of nature instead of a feverish, selfish little clod of ailments and grievances, complaining that the world will not devote itself to making you happy. I am of the opinion that my life belongs to the whole community and as long as I live, it is my privilege to do for it what I can. I want to be thoroughly used up when I die, for the harder I work, the more I live. I rejoice in life for its own sake. Life is no brief candle to me. It is a sort of splendid torch which I have got hold of for the moment and I want to make it burn as brightly as possible before handing it on to future generations.', author: 'George Bernard Shaw'),
            new Quote(quote: 'Wealth of information creates a poverty of attention', author: 'Herbert Simon'),
            new Quote(quote: 'Avoid having your ego so close to your position that when your position falls, your ego goes with it.', author: 'Colin Powell'),
            new Quote(quote: 'There is no enjoying the possession of anything valuable unless one has someone to share it with', author: 'Seneca'),
            new Quote(quote: 'Success consists of going from failure to failure without loss of enthusiasm', author: 'Winston Churchill'),
        ];

        return $this->render('app/landing.html.twig', [
            'quote' => $quotes[array_rand($quotes)],
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