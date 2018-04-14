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

    public function testEvaluateWithExponentNull(){
        $a = new PolynomialSummand(10);
        $this->assertEquals(10, $a->evaluate(1000));
        $this->assertEquals(10, $a->evaluate(0));
        $this->assertEquals(10, $a->evaluate(-1));
    }

    public function testEvaluateWithExponent(){
        $a = new PolynomialSummand(10, 2);
        $this->assertEquals(1000, $a->evaluate(10));
        $this->assertEquals(10, $a->evaluate(1));
        $this->assertEquals(0, $a->evaluate(0));
    }

    public function testMulNumber(){
        $a = new PolynomialSummand(7);
        $b = new PolynomialSummand(2);

        $a->mul($b);
        $this->assertEquals(14, $a->getNumber());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testMulExponentiation(){
        $a = new PolynomialSummand(7, -3);
        $b = new PolynomialSummand(2, 8);

        $a->mul($b);
        $this->assertEquals(14, $a->getNumber());
        $this->assertEquals(-24, $a->getExponentiation());
    }

    public function testUnCopiedCanBeChanged(){
        $a = new PolynomialSummand(42);
        $b = $a;
        $b->add(new PolynomialSummand(7));
        $this->assertEquals(49, $a->getNumber());
    }

    public function testCopiedCanNotBeChanged(){
        $a = new PolynomialSummand(42);
        $b = $a->copy();
        $b->add(new PolynomialSummand(7));
        $this->assertEquals(42, $a->getNumber());
        $this->assertEquals(49, $b->getNumber());
    }

    public function testToString(){
        $s = new PolynomialSummand(3, 2);
        $this->assertEquals("3x^2", $s->toString());

        $s = new PolynomialSummand(5, 0);
        $this->assertEquals("5", $s->toString());

        $s = new PolynomialSummand(-7, 3);
        $this->assertEquals("-7x^3", $s->toString());

        $s = new PolynomialSummand(-1, 3);
        $this->assertEquals("-x^3", $s->toString());

        $s = new PolynomialSummand(0, 12);
        $this->assertEquals("0", $s->toString());

        $s = new PolynomialSummand(1, 12);
        $this->assertEquals("x^12", $s->toString());

        $s = new PolynomialSummand(5, 1);
        $this->assertEquals("5x", $s->toString());
    }
}
