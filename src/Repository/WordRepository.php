<?php

namespace App\Repository;

use App\Entity\Word;
use App\Helper\WordHelper;
use App\Helper\LetterHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Exception;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    private LetterHelper $lettersHelper;
    private array $specialChars = ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'sch' => 'sch'];
    const BATCH_SIZE_DATABASE = 10;

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

    public function selectMaxLength()
    {
        return 10;
    }

    public function findRandom(): array
    {
        $start = 1;
        $maxLength = $this->selectMaxLength();
        $return = [];

        try {
            for ($wordLength = $start; $wordLength <= $maxLength; $wordLength++) {
                $query = $this->createQueryBuilder('w');
                $query->where(sprintf('w.length = %s', $wordLength));
                $query->orderBy($this->getRandomAlphabetOrder());
                $iterator = $query->getQuery()->toIterable();
                $return = [...$return, ...$this->getDataFromIteraterByBatchSize($iterator, self::BATCH_SIZE_DATABASE)];
            }
            return $return;
        } catch (Exception $e) {
            throw new \Doctrine\DBAL\Exception($e->getMessage());
        }
    }

    private function getDataFromIteraterByBatchSize($iterator, int $batchSize): array
    {
        $counter = 1;
        $return = [];
        foreach ($iterator as $k => $entity) {
            if ($batchSize < $counter) {
                return $return;
            }
            $return[] = $entity;
            $counter++;
        }
        return $return;
    }

    private function getRandomAlphabetOrder(string $alias = 'w'): string
    {
        $alphabet = $this->lettersHelper->getLettersAllShuffled();
        $alphabet = array_slice($alphabet, 0, 5);
        array_walk($alphabet, function (&$item) use ($alias) {
            $item = $alias . '.' . $item;
        });
        return implode(',', $alphabet);
    }

    /**
     * @param string $lettersOriginal
     * @param int $length
     * @return float|int|mixed|string
     */
    public function findByLetters(string $lettersOriginal, int $length = 0)
    {
        // letters that MUST NOT be in the word
        $lettersNotInWord = $this->lettersHelper->getLettersInverse($this->lettersHelper->getLettersFromString($lettersOriginal));

        $query = $this->createQueryBuilder('w');
        foreach ($lettersNotInWord as $letter) {
            // replace by ligature if specialchar
            // $letter = $this->specialChars[$letter] ?? $letter;
            // if ($this->checkSpecialChars($letter)) continue;

            $parameter = 'val_' . $letter;
            $query->andWhere("w.$letter = :$parameter");
            $query->setParameter($parameter, '0');
        }
        if (0 < $length) {
            $query->andWhere("w.length <= :length");
            $query->setParameter('length', $length);
        }

        // $query->setMaxResults(10);
        $query->orderBy('w.title');
        $rawSql = $this->getDqlWithParams($query);

        // return $query->getQuery()->getResult();
        $result = $query->getQuery()->getArrayResult();
        return $result;
    }

    private function getDqlWithParams(QueryBuilder $query)
    {
        $vals = $query->getParameters();
        $sql = $query->getDql();
        $sql = str_replace('?', '%s', $sql);

        $vals = (array)$vals->getValues();
        $values = [];
        foreach ($vals as $k => $v) {
            $values[':' . $v->getName()] = $v->getValue();
        }

        return str_replace(array_keys($values), $values, $sql);
    }

    /**
     * @param string $string
     * @return bool
     */
    private function checkSpecialChars(string $string): bool
    {
        return preg_match('/([a-z]{1,3})/i', $string);
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
