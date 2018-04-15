<?php 
use PHPUnit\FrameWork\TestCase;

use Math\RPolynomialSummand;

class RPolynomialSummandTest extends Testcase{

	public function setUp(){

    }
    
    public function testAdd(){
        $a = new RPolynomialSummand(13);
        $b = new RPolynomialSummand(42);

        $a->add($b);
        $this->assertEquals(55, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddZero(){
        $a = new RPolynomialSummand(0);
        $b = new RPolynomialSummand(0);

        $a->add($b);
        $this->assertEquals(0, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddNegative(){
        $a = new RPolynomialSummand(10);
        $b = new RPolynomialSummand(-42);

        $a->add($b);
        $this->assertEquals(-32, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    /**
     * @expectedException     Math\Exception\PolynomialSummand\WrongExponentiation
     */
    public function testAddThrowsExceptionWhenExponentiationIsWrong(){
        $a = new RPolynomialSummand(13, 0);
        $b = new RPolynomialSummand(42, 1);

        $a->add($b);
    }

    /**
     * @expectedException     Math\Exception\PolynomialSummand\WrongVariable
     */
    public function testAddThrowsExceptionWhenVariableIsWrong(){
        $a = new RPolynomialSummand(13, 0, "x");
        $b = new RPolynomialSummand(42, 0, "y");

        $a->add($b);
    }

    public function testEvaluateWithExponentNull(){
        $a = new RPolynomialSummand(10);
        $this->assertEquals(10, $a->evaluate(1000));
        $this->assertEquals(10, $a->evaluate(0));
        $this->assertEquals(10, $a->evaluate(-1));
    }

    public function testEvaluateWithExponent(){
        $a = new RPolynomialSummand(10, 2);
        $this->assertEquals(1000, $a->evaluate(10));
        $this->assertEquals(10, $a->evaluate(1));
        $this->assertEquals(0, $a->evaluate(0));
    }

    public function testMulNumber(){
        $a = new RPolynomialSummand(7);
        $b = new RPolynomialSummand(2);

        $a=$a->mul($b);
        $this->assertEquals(14, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testMulExponentiation(){
        $a = new RPolynomialSummand(7, -3);
        $b = new RPolynomialSummand(2, 8);

        $a=$a->mul($b);
        $this->assertEquals(14, $a->getNumber());
        $this->assertEquals(5, $a->getExponentiation());
    }

    public function testUnCopiedCanBeChanged(){
        $a = new RPolynomialSummand(42);
        $b = $a;
        $b->add(new RPolynomialSummand(7));
        $this->assertEquals(49, $a->getNumber());
    }

    public function testCopiedCanNotBeChanged(){
        $a = new RPolynomialSummand(42);
        $b = $a->copy();
        $b->add(new RPolynomialSummand(7));
        $this->assertEquals(42, $a->getNumber());
        $this->assertEquals(49, $b->getNumber());
    }

    public function testToString(){
        $s = new RPolynomialSummand(3, 2);
        $this->assertEquals("3x^2", $s->toString());

        $s = new RPolynomialSummand(5, 0);
        $this->assertEquals("5", $s->toString());

        $s = new RPolynomialSummand(-7, 3);
        $this->assertEquals("-7x^3", $s->toString());

        $s = new RPolynomialSummand(-1, 3);
        $this->assertEquals("-x^3", $s->toString());

        $s = new RPolynomialSummand(0, 12);
        $this->assertEquals("0", $s->toString());

        $s = new RPolynomialSummand(1, 12);
        $this->assertEquals("x^12", $s->toString());

        $s = new RPolynomialSummand(5, 1);
        $this->assertEquals("5x", $s->toString());
    }
}
