<?php

namespace App\Repository;

use App\Entity\Marque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Marque>
 *
 * @method Marque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marque[]    findAll()
 * @method Marque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marque::class);
    }

       /**
 * @return Query
 */
public function listemarquesCompletePaginee()
{
    return $this->createQueryBuilder('m')
        ->select('m')  // Sélectionnez toutes les colonnes que vous souhaitez
        ->orderBy('m.nomM', 'ASC')  // Tri par nom
        ->getQuery();
}

/**
     * Récupère les marques dont le nom commence par une lettre spécifiée
     *
     * @param string $search
     * @return Query
     */
    public function findBySearchQuery(string $search)
    {
        return $this->createQueryBuilder('m')
            ->where('m.NomM LIKE :search')
            ->setParameter('search', $search . '%')  
            ->orderBy('m.NomM', 'ASC')  
            ->getQuery();
    }

    /**
     * Retourne toutes les marques triés par nom
     *
     * @return Query
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.NomM', 'ASC')
            ->getQuery();
    }

//    /**
//     * @return Marque[] Returns an array of Marque objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Marque
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
