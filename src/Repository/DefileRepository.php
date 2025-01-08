<?php

namespace App\Repository;

use App\Entity\Defile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Defile>
 *
 * @method Defile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Defile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Defile[]    findAll()
 * @method Defile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Defile::class);
    }
    
        /**
    * @return Query 
     */
    public function listeDefilesCompletePaginee()
    {
        return $this->createQueryBuilder('d')
            ->select('d','m')
            ->leftJoin('d.marque','m')
            ->orderBy('d.NomD', 'ASC')         
            ->getQuery()
           
        ;
    }

  /**
     * Récupère les defile dont le nom commence par une lettre spécifiée
     *
     * @param string $search
     * @return Query
     */
    public function findBySearchQuery(string $search)
    {
        return $this->createQueryBuilder('d')
            ->where('d.NomD LIKE :search')
            ->setParameter('search', $search . '%')  
            ->orderBy('d.NomD', 'ASC') 
            ->getQuery();
    }

    /**
     * Retourne tous les defiles triés par nom
     *
     * @return Query
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.NomD', 'ASC')
            ->getQuery();
    }

    /**
     * Retourne la liste complète des defiles avec pagination
     *
     * @return Query
     */
    public function listeMannequinsCompletePaginee()
    {
        return $this->createQueryBuilder('a')
            ->select('a')  
            ->orderBy('a.Nom', 'ASC')  
            ->getQuery();
    }

    // Méthode supplémentaire si nécessaire pour d'autres requêtes
    // public function findOneBySomeField($value): ?Mannequins
    // {
    //     return $this->createQueryBuilder('m')
    //         ->andWhere('m.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}

//    /**
//     * @return Defile[] Returns an array of Defile objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Defile
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
