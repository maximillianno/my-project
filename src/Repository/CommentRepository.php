<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

//    /**
//     * @return Comment[] Returns an array of Comment objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLastComments(Page $page, $limit = 20){
        return $this->createQueryBuilder('c')
            ->where('c.page = :page')
            ->setParameter('page', $page)
            ->setMaxResults($limit)
            ->orderBy('c.id', 'desc')
            ->getQuery()
            ->getResult();
    }

    //Общее количество комментов
    public function countComments(){
        $qry = $this->createQueryBuilder('c')->select('count(c.id)');
        return $qry->getQuery()->getOneOrNullResult();
    }

    //возвращает конкретную страницу по несколько комментов
    public function findPages($page = 1, $limit = 10){
        $qry = $this->createQueryBuilder('c');
        $qry->setMaxResults($limit)->setFirstResult(($limit * $page) - $limit);
        return $qry->getQuery()->getResult();

    }
}
