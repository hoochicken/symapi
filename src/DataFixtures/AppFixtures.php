<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use App\Entity\Word;
use App\Helper\WordHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements FixtureGroupInterface
{

    const BATCH_SIZE_IMPORT = 200;

    public static function getGroups(): array
    {
        return ['general', 'word'];
    }

    public function load(ObjectManager $manager): void
    {
       $this->setWords($manager);
       // $this->setLetters($manager);
    }

    /**
     * @param $manager
     * @return void
     */
    private function setLetters(ObjectManager $manager)
    {
        $letters = array_merge(range('a', 'z'), ['sch', 'ae', 'oe', 'ue']);

        foreach ($letters as $letter) {
            $Letter = new Letter();
            $Letter->setTitle($letter);
            $Letter->setLigature($letter);
            $Letter->setState(true);
            $manager->persist($Letter);
        }
        $this->resetEntityManager($manager);
    }

    private function setWords(ObjectManager $manager)
    {
        $wordHelper = new WordHelper();
        $words = $wordHelper->getAllWords();

        $batchI = 0;
        foreach ($words as $oneWord) {

            if (0 === ($batchI % self::BATCH_SIZE_IMPORT)) {
                $this->resetEntityManager($manager);
                $batchI = 0;
            }

            $oneWord = trim($oneWord);
            if (empty($oneWord)) continue;
            $word = new Word();
            $word->setTitle(str_replace('-', '', $oneWord), true);
            $word->setDivided($oneWord, true);
            $manager->persist($word);
            unset($word);
            $batchI++;
        }
        $this->resetEntityManager($manager);
    }

    private function resetEntityManager(ObjectManager &$manager)
    {
        $manager->flush();
        $manager->clear();
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
    }
}
