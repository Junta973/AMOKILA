<?php

namespace App\Repository;

use App\Entity\ProjectChangeRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectChangeRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectChangeRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectChangeRequest[]    findAll()
 * @method ProjectChangeRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectChangeRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectChangeRequest::class);
    }

    public function getMyChangeRequests($user){
        return $this->createQueryBuilder('p')
            ->where('p.requestedBy = :user')
            ->setParameter('user',$user)
            ->getQuery()
            ->getResult();
    }

    public function getNbrResults(){
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function getNbrResultsByStats($status){
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.pcr_status = :status')
            ->setParameter('status',$status)
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

    public function search($pcrref,$pcrname,$pcretat,$user){
        $req = $this->createQueryBuilder('p');

        if ($pcrref)
            $req->andWhere('p.pcr_ref LIKE :ref')
                ->setParameter('ref','%'.$pcrref.'%');

        if ($pcrname)
            $req->andWhere('p.pcr_name LIKE :name')
                ->setParameter('name','%'.$pcrname.'%');

        if ($pcretat)
            $req->andWhere('p.pcr_status = :etat')
                ->setParameter('etat',$pcretat);

        if($user)
            $req->where('p.requestedBy = :user')
                ->setParameter('user',$user);

        $req = $req->getQuery()->getResult();

        return $req;
    }

    // /**
    //  * @return ProjectChangeRequest[] Returns an array of ProjectChangeRequest objects
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
    public function findOneBySomeField($value): ?ProjectChangeRequest
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
