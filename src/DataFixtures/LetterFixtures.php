<?php

namespace App\DataFixtures;

use App\Entity\Letter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class LetterFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
     {
         return ['letter'];
     }

    public function load(ObjectManager $manager): void
    {
       $this->setLetters($manager);
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    private function setLetters(ObjectManager $manager): void
    {
        $letters = array_merge(range('a', 'z'), ['sch', 'ae', 'oe', 'ue']);
        // $repo = $manager->getRepository('Letter');
        foreach ($letters as $letter) {
            // if (!$repo->letterExists($letter)) continue;
            $Letter = new Letter();
            $Letter->setTitle($letter);
            $Letter->setLigature($letter);
            $Letter->setState(true);
            $manager->persist($Letter);
        }
        $manager->flush();
    }
}
