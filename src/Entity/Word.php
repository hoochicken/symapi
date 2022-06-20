<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\ORM\Mapping as ORM;
use function PHPUnit\Framework\returnValueMap;

/**
 * @ORM\Entity(repositoryClass=WordRepository::class)
 */
class Word
{
    /** @var string[] key[char] => value[asci-repr.] */
    private $specialChars = ['sch' => 'sch', 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="smallint")
     */
    private $a = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $b = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $c = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $d = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $e = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $f = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $g = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $h = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $i = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $j = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $k = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $l = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $m = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $n = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $o = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $p = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $q = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $r = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $s = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $t = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $u = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $v = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $w = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $x = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $y = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $z = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ae = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $oe = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ue = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sch = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $divided;

    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @param bool $setLetters
     * @return $this
     */
    public function setTitle(string $title, bool $setLetters = false): Word
    {
        $this->title = $title;
        if ($setLetters) $this->setLetters($title);
        $this->setDivided($title);
        return $this;
    }

    /**
     * @param $title
     * @return void
     * check, which letters the word given has, so fill database
     * e. g. => "Pilot"     sets p,i,l,o,t              to 1/true
     * e. g. => "Röte"      sets r,oe,t,e               to 1/true
     * e. g. => "schreiben" sets s,c,h,sch,r,e,i,b,e,n  to 1/true
     */
    private function setLetters($title)
    {
        $word = strtolower($title);

        // split word into letters and set letter
        foreach ($this->splitWordIntoLetters($word) as $letter) {
            $this->setLetter($letter);
        }

        // set special chars, too
        // such as ä, ö, ü, sch
        foreach ($this->specialChars as $char => $translate) {
            // check if word has special char
            if (false === strpos($word, $char)) continue;

            // check if method exists
            if (false === $method = $this->getCharMethod($translate)) continue;
            // ... and use method
            $this->$method(1);
        }
    }

    /**
     * @return array
     */
    public function getLetters(): array
    {
        // split word into letters and set letter
        return array_unique($this->splitWordIntoLetters($this->getTitle()));
    }

    /**
     * @param $title
     * @return array|false
     * returns "Pilot" as [P,i,l,o,t]
     */
    public function splitWordIntoLetters($title)
    {
       return str_split($title, 1);
    }

    /**
     * @param string $char
     * @param string $prefix
     * @return false|string
     * check ist a set/get method of a character really exists
     */
    private function getCharMethod(string $char, string $prefix = 'set')
    {
        $method = $prefix . strtoupper($char);
        if (!method_exists($this, $method)) return false;
        return $method;
    }

    private function setLetter($letter)
    {
        $method = $this->getCharMethod($letter);
        if (false === $method) return;
        $this->$method(1);
    }

    public function getA(): ?int
    {
        return $this->a;
    }

    public function setA(int $a): self
    {
        $this->a = $a;
        return $this;
    }

    public function getB(): ?int
    {
        return $this->b;
    }

    public function setB(int $b): self
    {
        $this->b = $b;

        return $this;
    }

    public function getC(): ?int
    {
        return $this->c;
    }

    public function setC(int $c): self
    {
        $this->c = $c;

        return $this;
    }

    public function getD(): ?int
    {
        return $this->d;
    }

    public function setD(int $d): self
    {
        $this->d = $d;

        return $this;
    }

    public function getE(): ?int
    {
        return $this->e;
    }

    public function setE(int $e): self
    {
        $this->e = $e;

        return $this;
    }

    public function getF(): ?int
    {
        return $this->f;
    }

    public function setF(int $f): self
    {
        $this->f = $f;

        return $this;
    }

    public function getG(): ?int
    {
        return $this->g;
    }

    public function setG(int $g): self
    {
        $this->g = $g;

        return $this;
    }

    public function getH(): ?int
    {
        return $this->h;
    }

    public function setH(int $h): self
    {
        $this->h = $h;

        return $this;
    }

    public function getI(): ?int
    {
        return $this->i;
    }

    public function setI(int $i): self
    {
        $this->i = $i;

        return $this;
    }

    public function getJ(): ?int
    {
        return $this->j;
    }

    public function setJ(int $j): self
    {
        $this->j = $j;

        return $this;
    }

    public function getK(): ?int
    {
        return $this->k;
    }

    public function setK(int $k): self
    {
        $this->k = $k;

        return $this;
    }

    public function getL(): ?int
    {
        return $this->l;
    }

    public function setL(int $l): self
    {
        $this->l = $l;

        return $this;
    }

    public function getM(): ?int
    {
        return $this->m;
    }

    public function setM(int $m): self
    {
        $this->m = $m;

        return $this;
    }

    public function getN(): ?int
    {
        return $this->n;
    }

    public function setN(int $n): self
    {
        $this->n = $n;

        return $this;
    }

    public function getO(): ?int
    {
        return $this->o;
    }

    public function setO(int $o): self
    {
        $this->o = $o;

        return $this;
    }

    public function getP(): ?int
    {
        return $this->p;
    }

    public function setP(int $p): self
    {
        $this->p = $p;

        return $this;
    }

    public function getQ(): ?int
    {
        return $this->q;
    }

    public function setQ(int $q): self
    {
        $this->q = $q;

        return $this;
    }

    public function getR(): ?int
    {
        return $this->r;
    }

    public function setR(int $r): self
    {
        $this->r = $r;

        return $this;
    }

    public function getS(): ?int
    {
        return $this->s;
    }

    public function setS(int $s): self
    {
        $this->s = $s;

        return $this;
    }

    public function getT(): ?int
    {
        return $this->t;
    }

    public function setT(int $t): self
    {
        $this->t = $t;

        return $this;
    }

    public function getU(): ?int
    {
        return $this->u;
    }

    public function setU(int $u): self
    {
        $this->u = $u;

        return $this;
    }

    public function getV(): ?int
    {
        return $this->v;
    }

    public function setV(int $v): self
    {
        $this->v = $v;

        return $this;
    }

    public function getW(): ?int
    {
        return $this->w;
    }

    public function setW(int $w): self
    {
        $this->w = $w;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getZ(): ?int
    {
        return $this->z;
    }

    public function setZ(int $z): self
    {
        $this->z = $z;

        return $this;
    }

    public function getAe(): ?int
    {
        return $this->ae;
    }

    public function setAe(int $ae): self
    {
        $this->ae = $ae;

        return $this;
    }

    public function getOe(): ?int
    {
        return $this->oe;
    }

    public function setOe(int $oe): self
    {
        $this->oe = $oe;

        return $this;
    }

    public function getUe(): ?int
    {
        return $this->ue;
    }

    public function setUe(int $ue): self
    {
        $this->ue = $ue;

        return $this;
    }

    public function getSch(): ?int
    {
        return $this->sch;
    }

    public function setSch(int $sch): self
    {
        $this->sch = $sch;

        return $this;
    }

    public function getDivided(): ?string
    {
        return $this->divided;
    }

    public function setDivided(string $divided): self
    {
        $this->divided = $divided;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }
}
