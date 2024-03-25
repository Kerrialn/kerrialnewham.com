<?php

namespace App\Repository;

use App\Entity\Venture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Venture>
 *
 * @method Venture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Venture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Venture[]    findAll()
 * @method Venture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VentureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Venture::class);
    }


    /**
     * @param bool $isQuery
     * @return array<int, Venture>|Query
     */
    public function findByCreatedAt(bool $isQuery = false): array|Query
    {
        $qb = $this->createQueryBuilder('venture');

        $qb->orderBy('venture.createdAt', Order::Descending->value);

        if ($isQuery) {
            return $qb->getQuery();
        }

        return $qb->getQuery()->getResult();

    }
}
