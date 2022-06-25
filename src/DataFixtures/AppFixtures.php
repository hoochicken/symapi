<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use App\Entity\Word;
use App\Helper\WordHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $this->setWords($manager);
       $this->setLetters($manager);
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
        $manager->flush();
    }

    private function setWords(ObjectManager $manager)
    {
        // vielleicht hier letterweise, achtung, wird bei jedem durchlauf wieder alles gelöscht
        $wordHelper = new WordHelper();
        $words = $wordHelper->getAllWords('10-a');
        foreach ($words as $oneWord) {
            $word = new Word();
            $word->setTitle(str_replace('-', '', $oneWord), true);
            $word->setDivided($oneWord, true);
            $manager->persist($word);
        }
        $manager->flush();
    }
}
