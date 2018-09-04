<?php 
use PHPUnit\FrameWork\TestCase;

use Math\PolynomialSummand;

class RPolynomialSummandTest extends Testcase{

	public function setUp(){

    }
    
    public function testAdd(){
        $a = PolynomialSummand::new(13);
        $b = PolynomialSummand::new(42);

        $a->add($b);
        $this->assertEquals(55, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddZero(){
        $a = PolynomialSummand::new(0);
        $b = PolynomialSummand::new(0);

        $a->add($b);
        $this->assertEquals(0, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddNegative(){
        $a = PolynomialSummand::new(10);
        $b = PolynomialSummand::new(-42);

        $a->add($b);
        $this->assertEquals(-32, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    /**
     * @expectedException     Math\Exception\PolynomialSummand\WrongExponentiation
     */
    public function testAddThrowsExceptionWhenExponentiationIsWrong(){
        $a = PolynomialSummand::new(13, 0);
        $b = PolynomialSummand::new(42, 1);

        $a->add($b);
    }

    /**
     * @expectedException     Math\Exception\PolynomialSummand\WrongVariable
     */
    public function testAddThrowsExceptionWhenVariableIsWrong(){
        $a = PolynomialSummand::new(13, 0, "x");
        $b = PolynomialSummand::new(42, 0, "y");

        $a->add($b);
    }

    public function testEvaluateWithExponentNull(){
        $a = PolynomialSummand::new(10);
        $this->assertEquals(10, $a->evaluate(1000));
        $this->assertEquals(10, $a->evaluate(0));
        $this->assertEquals(10, $a->evaluate(-1));
    }

    public function testEvaluateWithExponent(){
        $a = PolynomialSummand::new(10, 2);
        $this->assertEquals(1000, $a->evaluate(10));
        $this->assertEquals(10, $a->evaluate(1));
        $this->assertEquals(0, $a->evaluate(0));
    }

    public function testMulNumber(){
        $a = PolynomialSummand::new(7);
        $b = PolynomialSummand::new(2);

        $a=$a->mul($b);
        $this->assertEquals(14, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testMulExponentiation(){
        $a = PolynomialSummand::new(7, -3);
        $b = PolynomialSummand::new(2, 8);

        $a=$a->mul($b);
        $this->assertEquals(14, $a->getNumber()->evaluate());
        $this->assertEquals(5, $a->getExponentiation());
    }

    public function testUnCopiedCanBeChanged(){
        $a = PolynomialSummand::new(42);
        $b = $a;
        $b->add(PolynomialSummand::new(7));
        $this->assertEquals(49, $a->getNumber()->evaluate());
    }

    public function testCopiedCanNotBeChanged(){
        $a = PolynomialSummand::new(42);
        $b = $a->copy();
        $b->add(PolynomialSummand::new(7));
        $this->assertEquals(42, $a->getNumber()->evaluate());
        $this->assertEquals(49, $b->getNumber()->evaluate());
    }

    public function testToString(){
        $s = PolynomialSummand::new(3, 2);
        $this->assertEquals("3x^2", $s->toString());

        $s = PolynomialSummand::new(5, 0);
        $this->assertEquals("5", $s->toString());

        $s = PolynomialSummand::new(-7, 3);
        $this->assertEquals("-7x^3", $s->toString());

        $s = PolynomialSummand::new(-1, 3);
        $this->assertEquals("-x^3", $s->toString());

        $s = PolynomialSummand::new(0, 12);
        $this->assertEquals("0", $s->toString());

        $s = PolynomialSummand::new(1, 12);
        $this->assertEquals("x^12", $s->toString());

        $s = PolynomialSummand::new(5, 1);
        $this->assertEquals("5x", $s->toString());
    }
}
