<?php 
use PHPUnit\FrameWork\TestCase;

use Math\PolynomialSummand;
use Math\Polynomial;

class FPolynomialSummandTest extends Testcase{

    public function testAdd(){
        $a = PolynomialSummand::new(1.3);
        $b = PolynomialSummand::new(2.5);

        $a->add($b);
        $this->assertEquals(3.8, $a->getNumber()->evaluate());
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
        $a = PolynomialSummand::new(10.3);
        $b = PolynomialSummand::new(-42.5);

        $a->add($b);
        $this->assertEquals(-32.2, $a->getNumber()->evaluate());
        $this->assertEquals(0, $a->getExponentiation());
    }



    public function testEvaluateWithExponentNull(){
        $a = PolynomialSummand::new(10);
        $this->assertEquals(10, $a->evaluate(1000));
        $this->assertEquals(10, $a->evaluate(0));
        $this->assertEquals(10, $a->evaluate(-1));
    }

    public function testEvaluateWithExponent(){
        $a = PolynomialSummand::new(10, 2);
        $this->assertEquals(1102.5, $a->evaluate(10.5));
        $this->assertEquals(10, $a->evaluate(1));
        $this->assertEquals(0, $a->evaluate(0));
    }

    public function testMulNumber(){
        $a = PolynomialSummand::new(7.8);
        $b = PolynomialSummand::new(2.42);

        $a=$a->mul($b);
        $this->assertEquals(18.876, $a->getNumber()->evaluate());
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
        $s = PolynomialSummand::new(3.5, 2);
        $this->assertEquals("3.5x^2", $s->toString());

        $s = PolynomialSummand::new(5.0, 0);
        $this->assertEquals("5.0", $s->toString());

        $s = PolynomialSummand::new(-7.4, 3);
        $this->assertEquals("-7.4x^3", $s->toString());

        $s = PolynomialSummand::new(-1, 3);
        $this->assertEquals("-x^3", $s->toString());

        $s = PolynomialSummand::new(0, 12);
        $this->assertEquals("0", $s->toString());

        $s = PolynomialSummand::new(0.0, 12);
        $this->assertEquals("0.0", $s->toString());

        $s = PolynomialSummand::new(1, 12);
        $this->assertEquals("x^12", $s->toString());

        $s = PolynomialSummand::new(5.0, 1);
        $this->assertEquals("5.0x", $s->toString());
    }

    public function testAddRtoF(){
        $a = PolynomialSummand::new(3.5, 2);
        $b = PolynomialSummand::new(4, 2);
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

        $a = PolynomialSummand::new(3.5, 2);
        $p2 = new \Math\Polynomial();
        $p2->addSummand($a);
        $this->assertEquals("3.5x^2", $p2->toString());
        $p->add($p2);
        $this->assertEquals("13.5x^2+3.0x^3", $p->toString());
       
    }

    public function testMulNumbers(){
        $a = new Polynomial();
        $b = new Polynomial();

        $a->addString("10x^2")->toFloat()->divNumber(3);
        $b->addString("20x^2")->toFloat();
        $c = $a->mul($b)->toFloat();
        $this->assertEquals("66.666666666667x^4", $c->toString());
        $this->assertEquals("3.3333333333333x^2", $a->toString());
        $this->assertEquals("20.0x^2", $b->toString());

        $d = new Polynomial();
        $d->addString("10x^2+5x")->toFloat();
        
        $e = new Polynomial();
        $e->addString("13x^2-10x+7x^5")->toFloat();
        $f = $d->mul($e)->toFloat();
        $this->assertEquals("-50.0x^2-35.0x^3+130.0x^4+35.0x^6+70.0x^7", $f->toString());
    }
}
