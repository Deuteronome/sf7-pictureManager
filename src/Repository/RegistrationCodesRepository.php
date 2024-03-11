<?php

namespace App\Repository;

use App\Entity\RegistrationCodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RegistrationCodes>
 *
 * @method RegistrationCodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistrationCodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistrationCodes[]    findAll()
 * @method RegistrationCodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationCodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistrationCodes::class);
    }

    //    /**
    //     * @return RegistrationCodes[] Returns an array of RegistrationCodes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RegistrationCodes
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
