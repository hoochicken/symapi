<?php

namespace App\Controller;

use App\Repository\LetterRepository;
use Symfony\Component\HttpFoundation\Request;

class LetterController extends ApiController
{
    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function indexAction(Request $request, LetterRepository $letterRepository)
    {
        return $this->respond(['letters' => $this->putSpecialCharsLast($letterRepository->findAllTitle())]);
        /*
        $letters = $letterRepository->findAllTitle();
        array_walk($letters, function(&$item) { $item = ['title' => $item, 'active' => false]; });
        return $this->respond(['letters' => $letters]);
        */
        // return $this->respond(['letters' => array_merge(range('a', 'z'), ['sch', 'ae', 'oe', 'ue'])]);
    }

    private function putSpecialCharsLast($array)
    {
        $specialChars = array_filter($array, function ($item) { return !in_array((string) $item, range('a', 'z')); });
        $alphabet = array_diff($array, $specialChars);
        return [...$alphabet, ...$specialChars];
    }
}
