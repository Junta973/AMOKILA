<?php

namespace App\Repository;

use App\Entity\Process;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Process|null find($id, $lockMode = null, $lockVersion = null)
 * @method Process|null findOneBy(array $criteria, array $orderBy = null)
 * @method Process[]    findAll()
 * @method Process[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Process::class);
    }

    public function getNbrResults(){
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function getLastResluts($nbr){
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($nbr)
            ->getQuery()
            ->getResult()
            ;
    }


    public function search($processref,$processname){
        $req = $this->createQueryBuilder('p');

        if ($processref)
            $req->andWhere('p.ref_process LIKE :ref')
                ->setParameter('ref','%'.$processname.'%');

        if ($processname)
            $req->andWhere('p.process_name LIKE :name')
                ->setParameter('name','%'.$processname.'%');

        $req = $req->getQuery()->getResult();

        return $req;
    }

    // /**
    //  * @return Process[] Returns an array of Process objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Process
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
