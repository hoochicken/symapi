<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 */
class PasswordRepository extends ServiceEntityRepository
{

    /**
     * @param int $length
     * @param int $count
     * @return array
     */
    public function generatePasswords(int $length = 15, int $count = 3): array
    {
        $passwords = [];
        for($i = 1; $i <= $count; $i++) {
            $passwords[] = $this->generatePassword($length);
        }
        return $passwords;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generatePassword(int $length = 10): string
    {
        $passwords_raw = ['sexypassword', 'tittyball', 'dick', 'prettycunt', 'clitoris', 'penisisapenis'];

        $password = $passwords_raw[array_rand($passwords_raw)];
        $password = $this->replaceLettersByNumbers($password);
        $password = $this->convertUrft8Hack($password);
        return substr($this->replaceLettersBySpecialChars($password) . $this->generateRandomString(), 0, $length);
    }

    /**
     * @param string $password
     * @return string
     */
    private function convertUrft8Hack(string $password): string
    {
        return utf8_encode($password);
    }

    /**
     * @param string $password
     * @return string
     */
    private function replaceLettersByNumbers(string $password): string
    {
        $replace1 = ['a' => 4, 'i' => '!', 'I' => 1, 's' => 5, 'S' => '$', 'o' => 0, '0' => 0, 'e' => 3, 'E' => 3];
        return str_replace(array_keys($replace1), $replace1, $password);
    }

    /**
     * @param string $password
     * @return string
     */
    private function replaceLettersBySpecialChars(string $password): string
    {
        $passwordArr = str_split($password);
        $replace2 = array_combine(range('a', 'z'), range('A', 'Z'));
        foreach ($passwordArr as $k => $letter) {
            if (1 !== rand(1, 3)) continue;
            $passwordArr[$k] = str_replace(array_keys($replace2), $replace2, $letter);
        }
        return implode($passwordArr);
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString(int $length = 5): string
    {
        $salt = [];
        $alphabet = array_merge(
            range('a', 'z'),
            range('A', 'Z'),
            range(0, 9),
            ['&', '%', '§']);
        $alphabet = implode($alphabet);
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, strlen($alphabet) - 1);
            $salt[$i] = $alphabet[$n];
        }
        return implode($salt);
    }
}
