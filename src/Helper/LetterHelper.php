<?php

namespace App\Helper;

use App\Repository\LetterRepository;

class LetterHelper
{
    private $separator = '-';
    private $lettersAll = [];

    public function __construct(LetterRepository $letterRepository)
    {
        // $this->lettersAll = $letterRepository->findAllTitle();
        $this->lettersAll = $letterRepository->findAllLigature();
    }

    /**
     * @param string $letters
     * @return array
     */
    public function getLettersFromString(string $letters): array
    {
        return str_contains($letters, $this->separator) ?
            array_unique(explode($this->separator, strtolower($letters))) :
            array_unique(str_split(strtolower($letters)));
    }

    /**
     * @param array $letters
     * @return array
     */
    public function getLettersInverse(array $letters = []): array
    {
        return array_diff($this->lettersAll, $letters);
    }
}