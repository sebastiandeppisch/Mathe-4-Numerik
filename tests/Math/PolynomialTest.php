<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Polynomial;
use \Math\PolynomialSummand;

class PolynomialTest extends Testcase{
    public function testToString(){
        $p = new Polynomial();
        $p->addSummand(new PolynomialSummand(3, 2));
        $this->assertEquals("3x^2", $p->toString());

        $p->addSummand(new PolynomialSummand(5, 4));
        $this->assertEquals("3x^2+5x^4", $p->toString());

        $p->addSummand(new PolynomialSummand(-7, 3));
        $this->assertEquals("3x^2-7x^3+5x^4", $p->toString());
    }

    public function testIsParsable(){
        $p = new Polynomial();

        $this->assertTrue($p->isParsable("4+10x^2+x^3"));
        $this->assertTrue($p->isParsable("123"));
        $this->assertTrue($p->isParsable("x"));
        $this->assertTrue($p->isParsable("x^2"));
        $this->assertTrue($p->isParsable("-4"));
        $this->assertFalse($p->isParsable("y"));
        $this->assertFalse($p->isParsable("4+10y^2+x^3"));
    }

    public function testaddString(){
        $p = new Polynomial();

        $this->assertEquals("4+10x^2+x^3", $p->addString("4+10x^2+x^3")->toString());
        $p->clear();
        $this->assertEquals("4", $p->addString("4")->toString());
        $p->clear();
        $this->assertEquals("-x", $p->addString("-x")->toString());
        $p->clear();
        $this->assertEquals("x^42", $p->addString("x^42")->toString());
        $p->clear();
        $this->assertEquals("0", $p->addString("")->toString());
        $p->clear();
        $this->assertEquals("0", $p->addString("0")->toString());
        $p->clear();
    }
 
    public function testAdd(){
        $a = new Polynomial();
        $b = new Polynomial();

        $a->addString("10x^2");
        $b->addString("20x^2");
        $a->add($b);

        $this->assertEquals("30x^2", $a->toString());

        $a->clear()->addString("42")->add($b);
        $this->assertEquals("42+20x^2", $a->toString());
    }

    public function testEvaluate(){
        $a = new Polynomial();
        
        $this->assertEquals(0, $a->evaluate(42));

        $a->addString("42");
        $this->assertEquals(42, $a->evaluate(42));

        $a->addString("x");
        $this->assertEquals(84, $a->evaluate(42));
    }

    public function testAddZero(){
        $a = new PolynomialSummand(0);
        $b = new PolynomialSummand(0);

        $p = new Polynomial();
        $p->addSummand($a)->addSummand($b);
        $this->assertEquals("0", $p->toString());
    }
    
    public function testMul(){
        $a = new Polynomial();
        $b = new Polynomial();

        $a->addString("10x^2");
        $b->addString("20x^2");
        $c = $a->mul($b);
        $this->assertEquals("200x^4", $c->toString());
        $this->assertEquals("10x^2", $a->toString());
        $this->assertEquals("20x^2", $b->toString());
    }

    public function testHTML(){
        $a = new Polynomial();
        $a->addString("4+10x^2+x^3");
        $this->assertEquals("4+10x<sup>2</sup>+x<sup>3</sup>", $a->toHTML());
    }

    public function testtoStringRationalNumber(){
        $a = new Polynomial();
        $a->addString("4+10x^2+x^3")->divNumber(3);
        $this->assertEquals("(4/3)+(10/3)x^2+(1/3)x^3", $a->toString());
    }
}
