<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use App\Model\FiltreBlog;

/**
 * @extends ServiceEntityRepository<Blog>
 *
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

   /**
    * @return Query Returns an array of Artiste objects
    */
    public function listeBlogsCompletePaginee(FiltreBlog $filtre = null): ?Query
    {
        $query = $this->createQueryBuilder('b')
            ->select('b')
            ->leftJoin('b.defile', 'd')
            ->orderBy('b.defile','ASC');  

        if (!empty($filtre->defile)) {
                $query->andWhere('b.defile = :defilerecherche')
                ->setParameter('defilerecherche', $filtre->defile);
        }
        ;
        return $query->getQuery();
    }







//    public function findOneBySomeField($value): ?Blog
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}