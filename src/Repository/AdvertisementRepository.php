<?php

namespace App\Repository;

use App\Entity\Advertisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Advertisement>
 *
 * @method Advertisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisement[]    findAll()
 * @method Advertisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisement::class);
    }

    public function add(Advertisement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Advertisement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function advancedSearchAd(?string $isAlone = null, ?string $city = null, ?string $pseudo = null, ?string $instrument = null)
    {

        $query = $this->createQueryBuilder('a');
        $query->innerJoin('a.user', 'user')
        ->addSelect('user');

        if($isAlone !== "Tous"){
            $query->where('user.isAlone = :isAlone')
            ->setParameter('isAlone', $isAlone);
        }
        

        if(!is_null($city)){
            $query->andWhere('a.city = :city')
            ->setParameter('city', $city);
        }

        if(!is_null($pseudo)){
            $query->andWhere('user.pseudo = :pseudo')
            ->setParameter('pseudo', $pseudo);
        }

        if(!is_null($instrument)){
            $query->andWhere('a.lookingFor = :instrument')
            ->setParameter('instrument', $instrument);
        }
        
        return $query->getQuery()->getResult();
    }


//    /**
//     * @return Advertisement[] Returns an array of Advertisement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Advertisement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
