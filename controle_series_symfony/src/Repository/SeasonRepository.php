<?php

namespace App\Repository;

use App\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Season>
 *
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    public function addSeasonsQuantity(int $seasonsQuantity, int $seriesId): void
    {
        $connection = $this->getEntityManager()->getConnection();

        $seasonsParam = array_fill(0, $seasonsQuantity, "($seriesId, ?)");
        $seasonsSql = 'INSERT INTO season (series_id, number) VALUES ' . implode(', ', $seasonsParam);
        $stm = $connection->prepare($seasonsSql);
        foreach (array_keys($seasonsParam) as $i) {
            $stm->bindValue($i + 1, $i + 1, \PDO::PARAM_INT);
        }
        $stm->executeQuery();
    }

    //    /**
    //     * @return Season[] Returns an array of Season objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Season
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
