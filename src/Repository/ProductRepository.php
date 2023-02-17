<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLatest(): array
    {
        // $dql = 'SELECT p FROM App\Entity\Product p ORDER BY p.id DESC';
        //$query = $this->getEntityManager()->createQuery($dql)->setMaxResults(12);

        //dd($query->getResult());
        //dd($query->getSQL());
        //createQueryBuilder
        return $this->createQueryBuilder('product')
            ->addSelect('Comments', 'tags')
            ->leftJoin('product.Comments', 'Comments')
            ->leftJoin('product.tags', 'tags')
            ->orderBy('product.id', 'DESC')
            ->getQuery()
            ->getResult();
        //dd($query->getResult());
        //dd($query->getDQL());      
    }
    public function findByTag($tag): array
    {
        return $this->createQueryBuilder('product')
            ->setParameter('tag', $tag)
            ->andWhere(':tag MEMBER OF product.tags')

            ->addSelect('Comments', 'tags')
            ->leftJoin('product.Comments', 'Comments')
            ->leftJoin('product.tags', 'tags')
            ->orderBy('product.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
