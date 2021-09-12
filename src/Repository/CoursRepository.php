<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

     /**
      * @return cours[] Returns an array of cours objects
      */

    public function findByDayField($day)
    {
        $startDate = new \DateTime();
        //dd($startDate->format('Y-m-d'));
        return $this->createQueryBuilder('c')
            ->andWhere('c.fait_le = :val')
            ->setParameter('val', $startDate->format('Y-m-d'))
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        /*$startDate = new \DateTime('01-'.$date.' 00:00:00');
        $endDate = (clone $startDate)->modify('+ 1 month - 1 second');

        $rentRelease = $rentReleaseRepository->createQueryBuilder('rent')
            ->where('userRentRelease = :user')
            ->andWhere('date BETWEEN :dateFrom AND :dateTo')
            ->setParameters([
                'user' => $this->getUser(),
                'dateFrom' => $startDate,
                'dateTo' => $endDate,
            ])
            ->getQuery()
            ->getResult();*/
    }

    /**
     * @return cours[] Returns an array of cours objects
     */

    public function findBetweenTwoDates($statdate,$enddate)
    {
        //$startDate = new \DateTime();
        return $this->createQueryBuilder('c')
            ->andWhere('c.start_at BETWEEN :from AND :to')
            ->setParameter('from', $statdate )
            ->setParameter('to', $enddate)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return cours[] Returns an array of cours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?cours
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
