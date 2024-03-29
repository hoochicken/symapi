<?php

namespace App\Repository;

use App\Entity\Letter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Letter>
 *
 * @method Letter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Letter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Letter[]    findAll()
 * @method Letter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LetterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Letter::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findAllTitle(): array
    {
        $letters = $this->findAll();
        array_walk($letters, function(&$item) {
            /** @var Letter $item */
            $item = $item->getTitle();}
        );
        return $letters;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findAllLigature(): array
    {
        $letters = $this->findAll();
        array_walk($letters, function(&$item) {
            /** @var Letter $item */
            $item = $item->getLigature();}
        );
        return $letters;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Letter $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Letter $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param string $title
     * @return float|int|mixed|string
     */
    public function findByTitle(string $title): mixed
    {
        $query = $this->createQueryBuilder('l');
        $query->andWhere("l.title = :title");
        $query->setParameter('title', $title);

        $query->orderBy('l.title');
        return $query->getQuery()->getResult();
    }

    /**
     * @param $letter
     * @return float|int|mixed|string
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function letterExists($letter): mixed
    {
        $letter = $this->findAllTitle($letter);
        return false;
    }

    // /**
    //  * @return Letter[] Returns an array of Letter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Letter
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
