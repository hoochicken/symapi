<?php

/** this file for some reason will cause an error due to double  */

namespace App\DataFixtures;

use App\Entity\Word;
use App\Helper\WordHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class WordFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['general'];
    }

    public function load(ObjectManager $manager): void
    {
       $this->setWords($manager);
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
