<?php

namespace App\Controller;

use App\Repository\LetterRepository;
use App\Repository\WordRepository;
use Symfony\Component\HttpFoundation\Request;

class WordController extends ApiController
{
    public function indexAction(Request $request)
    {
        return $this->respond(['password' => 'xxTESTxx']);
    }

    public function wordAction(Request $request, WordRepository $wordRepository)
    {
        $words = $wordRepository->findAll();
        array_walk($words, function(&$item) { $item = $item->getTitle(); });
        return $this->respond(['words' => $words]);
    }

    public function wordsByLetterAction(Request $request, WordRepository $wordRepository, LetterRepository $letterRepository, $letters = '')
    {
        $words = $wordRepository->findByLetters($letters);
        array_walk($words, function(&$item) { $item = $item->getTitle(); });
        return $this->respond(['words' => $words]);
    }
}
