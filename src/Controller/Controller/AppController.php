<?php

namespace App\Controller\Controller;

use App\Enum\ServiceEnum;
use App\Model\Quote;
use App\Repository\ArticleRepository;
use App\Repository\VentureRepository;
use InvalidArgumentException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/about-me', name: 'about')]
    public function about(): Response
    {
        return $this->render('app/about-me.html.twig');
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
            new Quote(quote: 'Dreams without goals, are just dreams and they ultimately fuel disappointment, on the road to achieving your dream you must apply disciple but more importantly consistency, because without commitment you\'ll never start, but without consistency you\'ll never finish.', author: 'Denzel Washington'),
            new Quote(quote: 'I have a foreboding of an America in my children\'s or grandchildren\'s time -- when the United States is a service and information economy; when nearly all the manufacturing industries have slipped away to other countries; when awesome technological powers are in the hands of a very few, and no one representing the public interest can even grasp the issues; when the people have lost the ability to set their own agendas or knowledgeably question those in authority; when, clutching our crystals and nervously consulting our horoscopes, our critical faculties in decline, unable to distinguish between what feels good and what\'s true, we slide, almost without noticing, back into superstition and darkness... The dumbing down of American is most evident in the slow decay of substantive content in the enormously influential media, the 30 second sound bites (now down to 10 seconds or less), lowest common denominator programming, credulous presentations on pseudoscience and superstition, but especially a kind of celebration of ignorance', author: 'Carl Sagan'),
        ];

        return $this->render('app/landing.html.twig', [
            'quote' => $quotes[array_rand($quotes)],
            'articles' => $articles,
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
            'venturesPagination' => $venturesPagination,
        ]);
    }

    #[Route('/services', name: 'services')]
    public function services(Request $request): Response
    {
        $service = ServiceEnum::tryFrom($request->get('service'));

        return match ($service) {
            ServiceEnum::MIGRATION => $this->render('service/migration.html.twig'),
            ServiceEnum::TRAINING => $this->render('service/training.html.twig'),
            default => throw new InvalidArgumentException('please select a valid service')
        };

    }
}