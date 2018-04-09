<?php 
use PHPUnit\FrameWork\TestCase;

use Math\PolynomialSummand;

class PolynomialSummandTest extends Testcase{

	public function setUp(){

    }
    
    public function testAdd(){
        $a = new PolynomialSummand(13);
        $b = new PolynomialSummand(42);

        $a->add($b);
        $this->assertEquals(55, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddZero(){
        $a = new PolynomialSummand(0);
        $b = new PolynomialSummand(0);

        $a->add($b);
        $this->assertEquals(0, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddNegative(){
        $a = new PolynomialSummand(10);
        $b = new PolynomialSummand(-42);

        $a->add($b);
        $this->assertEquals(-32, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    /**
     * @expectedException     Math\Exception\PolynomialSummand\WrongExponentiation
     */
    public function testAddThrowsExceptionWhenExponentiationIsWrong(){
        $a = new PolynomialSummand(13, 0);
        $b = new PolynomialSummand(42, 1);

        $a->add($b);
    }

    /**
     * @expectedException     Math\Exception\PolynomialSummand\WrongVariable
     */
    public function testAddThrowsExceptionWhenVariableIsWrong(){
        $a = new PolynomialSummand(13, 0, "x");
        $b = new PolynomialSummand(42, 0, "y");

        $a->add($b);
    }
}
