<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findUpcoming(
        ?string $startDate = null,
        ?string $endDate = null
    )
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.startDate > :now')
            ->setParameter('now', new \DateTime());

        // Dilters results by date in DQL
        // Startdate is set at 00;00, Enddate is set at 23:59
        if ($startDate !== null) {
            $start = \DateTime::createFromFormat('Y-m-d', $startDate);
            $start->setTime(0, 0);
            $end = \DateTime::createFromFormat('Y-m-d', $endDate);
            $end->setTime(23, 59);

            $qb->andWhere('e.startDate > :start')
                ->andWhere('e.startDate < :end')
                ->setParameter('start', $start)
                ->setParameter('end', $end);
        }
        // Order by ascending start date
        return $qb
            ->orderBy('e.startDate', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
