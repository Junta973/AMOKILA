<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
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

    public function getLastTaskOnProgress($nb){
        return $this->createQueryBuilder('t')
            ->where('t.progress < 100 and t.progress > 0')
            ->orderBy('t.id','DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }

    public function search($reftask,$nametask,$minprogress,$maxprogress){
        $req = $this->createQueryBuilder('p');

        if ($reftask)
            $req->andWhere('p.task_ref LIKE :ref')
                ->setParameter('ref','%'.$reftask.'%');

        if ($nametask)
            $req->andWhere('p.task_name LIKE :name')
                ->setParameter('name','%'.$nametask.'%');

        if ($minprogress)
            $req->andWhere('p.progress > :minprog')
                ->setParameter('minprog', $minprogress);

        if ($maxprogress)
            $req->andWhere('p.progress < :maxprog')
                ->setParameter('maxprog', $maxprogress);

        $req = $req->getQuery()->getResult();

        return $req;
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
