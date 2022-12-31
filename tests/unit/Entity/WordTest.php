<?php

namespace App\Tests\Entity;

use App\Entity\Word;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    public function testLetterSplitting()
    {
        $word = new Word();
        $word->setTitle('test', true);
        $letters = $word->getLetters();
        $this->assertIsArray($letters);
    }

    public function testCharacters()
    {
        $word = new Word();
        $word->setTitle('test', true);
        $this->assertEquals(1, $word->getT());
        $this->assertEquals(1, $word->getE());
        $this->assertEquals(1, $word->getS());
        $this->assertEquals(0, $word->getSch());
        $this->assertEquals(0, $word->getR());

        $letters = $word->getLetters();
        $this->assertIsArray($letters);
    }

    public function testSpecialChars()
    {
        $word = new Word();
        $word->setTitle('schäume', true);
        $this->assertEquals(1, $word->getS());
        $this->assertEquals(1, $word->getSch());
        $this->assertEquals(1, $word->getAe());
        $this->assertEquals(0, $word->getX());
        $this->assertEquals(0, $word->getR());
        $this->assertEquals(0, $word->getR());
    }
}
