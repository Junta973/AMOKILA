<?php

namespace App\Repository;

use App\Entity\Material;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Material|null find($id, $lockMode = null, $lockVersion = null)
 * @method Material|null findOneBy(array $criteria, array $orderBy = null)
 * @method Material[]    findAll()
 * @method Material[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }


    public function countValide()
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->andWhere('m.date_validation_out > :val')
            ->setParameter('val', (new \DateTime()))
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function search($ref,$name,$etat){
        $req = $this->createQueryBuilder('p');

        if ($ref)
            $req->andWhere('p.ref_material LIKE :ref')
                ->setParameter('ref','%'.$ref.'%');

        if ($name)
            $req->andWhere('p.name_material LIKE :name')
                ->setParameter('name','%'.$name.'%');

        if ($etat == "1")
            $req->andWhere('p.date_validation_out > :jour')
                ->setParameter('jour', (new \DateTime()));
        elseif ($etat == "0")
            $req->andWhere('p.date_validation_out < :jouro')
                ->setParameter('jouro', (new \DateTime()));

        $req = $req->getQuery()->getResult();

        return $req;
    }
    /*
    public function findOneBySomeField($value): ?Material
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
