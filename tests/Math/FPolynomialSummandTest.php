<?php 
use PHPUnit\FrameWork\TestCase;

use Math\RPolynomialSummand;
use Math\FPolynomialSummand;

class FPolynomialSummandTest extends Testcase{

    public function testAdd(){
        $a = new FPolynomialSummand(1.3);
        $b = new FPolynomialSummand(2.5);

        $a->add($b);
        $this->assertEquals(3.8, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddZero(){
        $a = new FPolynomialSummand(0);
        $b = new FPolynomialSummand(0);

        $a->add($b);
        $this->assertEquals(0, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testAddNegative(){
        $a = new FPolynomialSummand(10.3);
        $b = new FPolynomialSummand(-42.5);

        $a->add($b);
        $this->assertEquals(-32.2, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }



    public function testEvaluateWithExponentNull(){
        $a = new FPolynomialSummand(10);
        $this->assertEquals(10, $a->evaluate(1000));
        $this->assertEquals(10, $a->evaluate(0));
        $this->assertEquals(10, $a->evaluate(-1));
    }

    public function testEvaluateWithExponent(){
        $a = new FPolynomialSummand(10, 2);
        $this->assertEquals(1102.5, $a->evaluate(10.5));
        $this->assertEquals(10, $a->evaluate(1));
        $this->assertEquals(0, $a->evaluate(0));
    }

    public function testMulNumber(){
        $a = new FPolynomialSummand(7.8);
        $b = new FPolynomialSummand(2.42);

        $a=$a->mul($b);
        $this->assertEquals(18.876, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }

    public function testMulExponentiation(){
        $a = new FPolynomialSummand(7, -3);
        $b = new FPolynomialSummand(2, 8);

        $a=$a->mul($b);
        $this->assertEquals(14, $a->getNumber()->evaluate());
        $this->assertEquals(5, $a->getExponentiation());
    }

    public function testUnCopiedCanBeChanged(){
        $a = new FPolynomialSummand(42);
        $b = $a;
        $b->add(new FPolynomialSummand(7));
        $this->assertEquals(49, $a->getNumber()->evaluate());
    }

    public function testCopiedCanNotBeChanged(){
        $a = new FPolynomialSummand(42);
        $b = $a->copy();
        $b->add(new FPolynomialSummand(7));
        $this->assertEquals(42, $a->getNumber()->evaluate());
        $this->assertEquals(49, $b->getNumber()->evaluate());
    }

    public function testToString(){
        $s = new FPolynomialSummand(3.5, 2);
        $this->assertEquals("3.5x^2", $s->toString());

        $s = new FPolynomialSummand(5, 0);
        $this->assertEquals("5.0", $s->toString());

        $s = new FPolynomialSummand(-7.4, 3);
        $this->assertEquals("-7.4x^3", $s->toString());

        $s = new FPolynomialSummand(-1, 3);
        $this->assertEquals("-x^3", $s->toString());

        $s = new FPolynomialSummand(0, 12);
        $this->assertEquals("0", $s->toString());

        $s = new FPolynomialSummand(1, 12);
        $this->assertEquals("x^12", $s->toString());

        $s = new FPolynomialSummand(5, 1);
        $this->assertEquals("5.0x", $s->toString());
    }

    public function testAddRtoF(){
        $a = new FPolynomialSummand(3.5, 2);
        $b = new RPolynomialSummand(4, 2);
        $b = $b->toFloat();
        $a->add($b);

        $this->assertEquals(7.5, $a->getNumber()->evaluate());
        $this->assertEquals(2, $a->getExponentiation());
    }

    public function testConverToFloat(){
        $p = new Math\Polynomial();
        $p->addString("2x^2+3x^3+8x^2");
        $this->assertEquals("10x^2+3x^3", $p->toString());
        $p->toFloat();
        $this->assertEquals("10.0x^2+3.0x^3", $p->toString());

        $a = new FPolynomialSummand(3.5, 2);
        $p2 = new \Math\Polynomial();
        $p2->addSummand($a);
        $this->assertEquals("3.5x^2", $p2->toString());
        $p->add($p2);
        $this->assertEquals("13.5x^2+3.0x^3", $p->toString());
       
    }
}
