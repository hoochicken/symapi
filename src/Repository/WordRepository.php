<?php

namespace App\Repository;

use App\Entity\Word;
use App\Helper\WordHelper;
use App\Helper\LetterHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    private $lettersHelper;

    public function __construct(ManagerRegistry $registry, LetterRepository $letterRepository)
    {
        $this->lettersHelper = new LetterHelper($letterRepository);
        parent::__construct($registry, Word::class);
    }

    /**
     * @param Word $entity
     * @param bool $flush
     */
    public function add(Word $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Word $entity
     * @param bool $flush
     */
    public function remove(Word $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param string $lettersOriginal
     * @return float|int|mixed|string
     */
    public function findByLetters(string $lettersOriginal)
    {
        $lettersForbidden = $this->lettersHelper->getLettersInverse($this->lettersHelper->getLettersFromString($lettersOriginal));

        $query = $this->createQueryBuilder('w');
        foreach ($lettersForbidden as $letter) {
            $parameter = 'val_' . $letter;
            $query->andWhere("w.$letter= :$parameter");
            $query->setParameter($parameter, '0');
        }

        // $query->setMaxResults(10);
        $query->orderBy('w.title');
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Word[] Returns an array of Word objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Word
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getAllWords($wordLengthByletters = 0): array
    {
        $wordHelper = new WordHelper();
        return $wordHelper->getAllWords($wordLengthByletters);
    }
}
