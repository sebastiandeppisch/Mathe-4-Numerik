<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\RationalNumber;

class RationalNumberTest extends Testcase{

    public function testPhasAlwaysTheSign(){
        $a = new RationalNumber(-1, 2);
        $this->assertEquals(-1, $a->getP());
        $a->setQ(-2);
        $this->assertEquals(1, $a->getP());
        $this->assertEquals(2, $a->getQ());

        $b = new RationalNumber(1, -2);
        $this->assertEquals(-1, $b->getP());
        $this->assertEquals(2, $b->getQ());

        $c = new RationalNumber(-1, -2);
        $this->assertEquals(1, $c->getP());
        $this->assertEquals(2, $c->getQ());
    }

    public function testAdd(){
        $a = new RationalNumber(1, 1);
        $b = new RationalNumber(2, 1);
        $a->add($b);
        $this->assertEquals(3, $a->getP());
        $this->assertEquals(1, $a->getQ());

        $c = new RationalNumber(17, 21);
        $d = new RationalNumber(44, 35);
        $c->add($d);
        $this->assertEquals(217, $c->getP());
        $this->assertEquals(105, $c->getQ());
    }

    public function testAddNegative(){
        $a = new RationalNumber(17, 21);
        $b = new RationalNumber(-44, 35);
        $a->add($b);
        $this->assertEquals(-47, $a->getP());
        $this->assertEquals(105, $a->getQ());

        $c = new RationalNumber(17, -21);
        $d = new RationalNumber(44, 35);
        $c->add($d);
        $this->assertEquals(-47, $a->getP());
        $this->assertEquals(105, $a->getQ());
    }

    public function testFactorization(){
        $a = new RationalNumber(0, 0);

        $this->assertEquals([1], $a->factorization(1));
        $this->assertEquals([2], $a->factorization(2));
        $this->assertEquals([2,3,5], $a->factorization(30));
        $this->assertEquals([37], $a->factorization(37));
        $this->assertEquals([2,2,2,3,17,17], $a->factorization(6936));
    }

    public function testLeastCommonMultiple(){
        $a = new RationalNumber(0, 0);
        $this->assertEquals(1, $a->lcm(1, 1));
        $this->assertEquals(36, $a->lcm(12, 18));
        $this->assertEquals(52920, $a->lcm(3528, 3780));
    }
}
