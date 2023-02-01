<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Post[] Returns an array of Post objects
    */
   public function findAllSumOfComment()
   {
       return $this->createQueryBuilder('p')
       ->select('p.id as postId, COUNT(pc.id) as totalComment')
       ->leftJoin('p.postComments', 'pc')
       ->where('p.id = pc.idPost')
       ->groupBy('p.id')
       ->getQuery()
       ->getResult()  
       ;
   }

   public function findAllWithSumOfLike ()
   {
       return $this->createQueryBuilder('p')
       ->select('p.id, p.title,p.imageName, p.content, p.createdAt,  p.updatedAt, p.isActive, pr.firstname, pr.lastname, pr.imageName as authorPix, pr.isActive as profilOk,  SUM(l.isActive) as likes')
       ->leftJoin('p.postLikes', 'l')
       ->leftJoin('p.idProfil','pr')
       ->where('l.isActive = 1')
       ->groupBy('p.id')
       ->getQuery()
       ->getResult()
       ;
   }


//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
