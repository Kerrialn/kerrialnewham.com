<?php

namespace App\Repository;

use App\DataTransferObject\ArticleFilterDto;
use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

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
        dump($articleFilterDto->getTag());

        $qb = $this->createQueryBuilder('article');

        if (!empty($articleFilterDto->getKeyword())) {
            $qb->andWhere(
                $qb->expr()->like($qb->expr()->lower('article.title'), ':keyword')
            )->setParameter('keyword', '%' . strtolower($articleFilterDto->getKeyword()) . '%');
        }

        $qb->andWhere(
            $qb->expr()->isNotNull('article.publishedAt')
        );

        if ($articleFilterDto->getTag() instanceof Tag) {
            $qb->leftJoin('article.tags', 'tag');

            $qb->andWhere(
                $qb->expr()->eq('tag.id', ':tag')
            )->setParameter('tag', $articleFilterDto->getTag());
        }

        if ($isQuery) {
            return $qb->getQuery();
        }

        return $qb->getQuery()->getResult();

    }
}
