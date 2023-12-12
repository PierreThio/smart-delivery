<?php

namespace App\Repository;

use App\Entity\NotificationContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotificationContent>
 *
 * @method NotificationContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationContent[]    findAll()
 * @method NotificationContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationContent::class);
    }

//    /**
//     * @return NotificationContent[] Returns an array of NotificationContent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NotificationContent
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
