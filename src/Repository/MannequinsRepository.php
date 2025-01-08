<?php

namespace App\Repository;

use App\Entity\Mannequins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Mannequins>
 *
 * @method Mannequins|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mannequins|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mannequins[]    findAll()
 * @method Mannequins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MannequinsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mannequins::class);
    }

    /**
     * Récupère les mannequins dont le nom commence par une lettre spécifiée
     *
     * @param string $search
     * @return Query
     */
    public function findBySearchQuery(string $search)
    {
        return $this->createQueryBuilder('m')

        ->leftJoin('m.defiles', 'd') // Jointure avec les défilés (assumant que 'm.defiles' représente la relation)
        ->addSelect('d') // Sélection des défilés associés
        ->where('m.Nom LIKE :search')
        ->orWhere('m.Prenom LIKE :search') // Recherche aussi sur le prénom
        ->orWhere('m.Nationalite LIKE :search') // Recherche aussi sur la nationalité
        ->orWhere('d.nom LIKE :search') // Recherche aussi sur le nom des défilés
        ->setParameter('search', $search . '%')
        ->orderBy('m.Nom', 'ASC')
        ->getQuery();
    }

    /**
     * Retourne tous les mannequins triés par nom,prenom....
     *
     * @return Query
     */
    public function findAllQuery()
    {
        return $this->createQueryBuilder('m')
        ->leftJoin('m.defiles', 'd') // Jointure avec les défilés
        ->addSelect('d') // Sélectionner les défilés associés
        ->addSelect('m.Prenom') // Sélectionner le prénom
        ->addSelect('m.Nationalite') // Sélectionner la nationalité
        ->orderBy('m.Nom', 'ASC')  // Tri par nom de mannequin
        ->getQuery();
    }

    /**
     * Retourne la liste complète des mannequins avec pagination
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

    public function findByDefile($defileId)
{
    return $this->createQueryBuilder('m')
        ->innerJoin('m.defiles', 'd') 
        ->where('d.id = :defileId')
        ->setParameter('defileId', $defileId)
        ->getQuery()
        ->getResult();
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
