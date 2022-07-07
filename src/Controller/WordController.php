<?php

namespace App\Controller;

use App\Repository\LetterRepository;
use App\Repository\WordRepository;
use Symfony\Component\HttpFoundation\Request;

class WordController extends ApiController
{
    private $limit = 1000;

    public function indexAction(Request $request)
    {
        return $this->respond(['password' => 'xxTESTxx']);
    }

    public function wordAction(Request $request, WordRepository $wordRepository)
    {
        $words = $this->getRandomElements($wordRepository->findAll());
        array_walk($words, function(&$item) { $item = $item->getTitle(); });
        return $this->respond(['words' => $words]);
    }

    public function wordsByLetterAction(Request $request, WordRepository $wordRepository, LetterRepository $letterRepository, $letters = '', $length = 0)
    {
        $words = $this->getRandomElements($wordRepository->findByLetters($letters, $length));
        array_walk($words, function(&$item) { $item = $item->getTitle(); });
        return $this->respond(['words' => $words]);
    }

    private function getRandomElements(array $array, int $num = 1000): array
    {
        if (0 === count($array)) return [];
        $keysOfArray = array_rand($array, min($num, count($array)));
        $array = array_filter($array, function($k) use ($keysOfArray) {
            return in_array($k, $keysOfArray);
        }, ARRAY_FILTER_USE_KEY);
        sort($array);
        return $array;
    }
}
