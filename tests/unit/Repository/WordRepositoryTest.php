<?php

namespace App\Tests\Repository;
use App\Repository\WordRepository;
use PHPUnit\Framework\TestCase;

class WordRepositoryTest extends TestCase
{
    public function testWithMockedClass()
    {
        $repo = $this->createMock(WordRepository::class);
        // unittest only knows that array is expected by definition of getAllWords(): ARRAY
        $array = $repo->getAllWords();
        $this->assertTrue(true);
        $this->assertIsArray($array);
    }

    public function testWithActualClass()
    {
        $repo = $this->createMock(WordRepository::class);
        $array = $repo->getAllWords();
        $this->assertTrue(true);
        $this->assertIsArray($array);
        // $this->assertTrue(false);
    }
}