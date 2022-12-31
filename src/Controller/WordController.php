<?php

namespace App\Controller;

use App\Repository\LetterRepository;
use App\Repository\WordRepository;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WordController extends ApiController
{
    private $limit = 1000;

    public function indexAction(Request $request)
    {
        return $this->respond(['password' => 'xxTESTxx']);
    }

    public function wordAction(Request $request, WordRepository $wordRepository)
    {
        try {
            $words = $this->getRandomElements($wordRepository->findAll());
            array_walk($words, function (&$item) {
                $item = $item->getTitle();
            });
            return $this->respond(['words' => $words]);
        } catch (Exception $e) {
            throw new HttpException('Something went wrong when getting the words');
        }

    }

    public function wordsByLetterAction(Request $request, WordRepository $wordRepository, LetterRepository $letterRepository, $letters = '', $length = 0)
    {
        try {
            $words = $this->getRandomElements($wordRepository->findByLetters($letters, $length));
            array_walk($words, function (&$item) {
                $item = $item->getTitle();
            });
            return $this->respond(['words' => $words, 'result' => 'ok']);
        } catch (Exception $e) {
            throw new HttpException($e->getCode(), $e->getMessage() . 'Something went wrong when getting the words');
        }

    }

    private function getRandomElements(array $array, int $num = 1000): array
    {
        if (0 === count($array)) return [];
        if (1 === count($array)) return $array;
        $keysOfArray = array_rand($array, min($num, count($array)));
        $array = array_filter($array, function ($k) use ($keysOfArray) {
            return in_array($k, $keysOfArray);
        }, ARRAY_FILTER_USE_KEY);
        sort($array);
        return $array;
    }
}
