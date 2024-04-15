<?php

namespace App\Repository;

use App\DataTransferObject\ArticleFilterDto;
use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly LoggerInterface $logger,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return array<int, Article>|Query
     */
    public function findRecentlyPublished(bool $isQuery = false): array|Query
    {

        $qb = $this->createQueryBuilder('article');
        $qb->orderBy('article.createdAt', Order::Descending->value)
            ->setMaxResults(5);

        $qb->andWhere(
            $qb->expr()->isNotNull('article.publishedAt')
        );

        if ($isQuery) {
            return $qb->getQuery();
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array<int, Article>|Query
     */
    public function findByFilter(ArticleFilterDto $articleFilterDto, bool $isQuery = false): Query|array
    {
        $qb = $this->createQueryBuilder('article');
        $qb->leftJoin('article.tags', 'tag');

        if (!empty($articleFilterDto->getKeyword())) {
            $qb->andWhere(
                $qb->expr()->like($qb->expr()->lower('article.title'), ':keyword')
            )->setParameter('keyword', '%' . strtolower($articleFilterDto->getKeyword()) . '%');
        }

        $qb->andWhere(
            $qb->expr()->isNotNull('article.publishedAt')
        );

        if ($articleFilterDto->getTags()->count() > 0) {
            $ids = $articleFilterDto->getTags()->map(function (Tag $tag): string {
                return $tag->getId()->toRfc4122();
            });

            $qb->andWhere(
                $qb->expr()->in('tag.id', ':ids')
            )->setParameter('ids', $ids->toArray());
        }

        if ($isQuery) {
            return $qb->getQuery();
        }

        $this->logger->debug(message: $qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();

    }
}
