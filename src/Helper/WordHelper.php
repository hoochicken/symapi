<?php

namespace App\Helper;

class WordHelper
{
    private $specialChars = ['ß' => 'ss'];
    private $filenames = [2, 3, 4, 5, 6, 7, 8, 9, 10];

    public function getAllWords($wordLengthByletters = 0): array
    {
        // $this->filterWordEnding();
        $wordLengthByletters =
            0 === $wordLengthByletters || is_array($wordLengthByletters) ? $this->filenames :
                (is_int($wordLengthByletters) ? [$wordLengthByletters] : $wordLengthByletters);

        $wordsInFile = [];
        foreach ($wordLengthByletters as $i) {
            if (!in_array($i, $this->filenames)) continue;
            $wordsInFile[] = $this->getWordsByFile( $i . '.txt');
        }
        array_walk($wordsInFile, function (&$item) {$item = explode("\n", str_replace("\r", '', $item));});
        return call_user_func_array('array_merge', $wordsInFile);
    }

    private function getWordsByFile($filename): string
    {
        return $this->replaceSpecialChars(file_get_contents(__DIR__ . '/../words/' . $filename));
    }

    private function replaceSpecialChars($string): string
    {
        return str_replace(array_keys($this->specialChars), $this->specialChars, $string);
    }

    private function filterWordEnding(string $ending = 's')
    {
        $ending = 'en';
        $nomen = true;
        $majuskeln = range('A', 'Z');
        $stringLength = strlen($ending) * (-1);
        for ($i = 2; $i <= 10; $i++) {
            $strWords = file_get_contents(__DIR__ . '/../words/' . $i . '.txt');
            $arrWords = explode("\n", str_replace("\r", '', $strWords));
            sort($arrWords);
            file_put_contents(__DIR__ . '/../words/' . $i . '.txt', implode("\n", $arrWords));
            $arrWordsGenitiv = $this->checkConditions($arrWords, $ending, $stringLength, $nomen, $majuskeln);
            $arrWordsNormal = $arrWords;
            $arrWords = array_merge($arrWordsGenitiv, $arrWordsNormal);
            $arrWords = array_unique($arrWords);

            file_put_contents(__DIR__ . '/../words/' . $i . '.txt', implode("\n", $arrWords));
            $wordsInFile[] = $strWords;
        }
        array_walk($wordsInFile, function (&$item) {$item = explode("\n", str_replace("\r", '', $item));});
        $wordsInFile = call_user_func_array('array_merge', $wordsInFile);
        sort($wordsInFile);
        $wordsInFile = $this->checkConditions($arrWords, $ending, $stringLength, $nomen, $majuskeln);
        die(implode('<br />', $wordsInFile));
        return $wordsInFile;
    }

    private function checkConditions($arrWords, $ending, $stringLength, $nomen, $majuskeln)
    {
        return array_filter($arrWords,
            function ($item) use ($ending, $stringLength, $nomen, $majuskeln) {
                return
                    $nomen &&
                    in_array(substr($item, 0, 1), $majuskeln) &&
                    $ending === substr($item, $stringLength)
                    ;
            }
        );
    }
}