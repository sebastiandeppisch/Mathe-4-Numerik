<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Polynomial;
use \Math\RPolynomialSummand;

class PolynomialTest extends Testcase{
    public function testToString(){
        $p = new Polynomial();
        $p->addSummand(new RPolynomialSummand(3, 2));
        $this->assertEquals("3x^2", $p->toString());

        $p->addSummand(new RPolynomialSummand(5, 4));
        $this->assertEquals("3x^2+5x^4", $p->toString());

        $p->addSummand(new RPolynomialSummand(-7, 3));
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
        $a = new RPolynomialSummand(0);
        $b = new RPolynomialSummand(0);

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
        $this->assertEquals('<div class="polynomial"><div class="polnomialsummand-outer"><div class="polynomialsummand"><div class="rationalnumber">4</div></div></div><div class="polnomialsummand-outer"><div class="polnomialsummand-sign">+</div><div class="polynomialsummand"><div class="rationalnumber">10</div>x<sup>2</sup></div></div><div class="polnomialsummand-outer"><div class="polnomialsummand-sign">+</div><div class="polynomialsummand"><div class="rationalnumber">1</div>x<sup>3</sup></div></div></div>', $a->toHTML());
    }

    public function testtoStringRationalNumber(){
        $a = new Polynomial();
        $a->addString("-4+10x^2+x^3")->divNumber(3);
        $this->assertEquals("-(4/3)+(10/3)x^2+(1/3)x^3", $a->toString());

        $b = new Polynomial();
        $b->addString("4-10x^2+x^3")->divNumber(3);
        $this->assertEquals("(4/3)-(10/3)x^2+(1/3)x^3", $b->toString());

        $c = new Polynomial();
        $c->addString("4-10x^2+x^3")->divNumber(-2);
        $this->assertEquals("-2+5x^2-(1/2)x^3", $c->toString());
    }

    public function testMulRationalNumbers(){
        $a = new Polynomial();
        $b = new Polynomial();

        $a->addString("10x^2")->divNumber(3);
        $b->addString("20x^2");
        $c = $a->mul($b);
        $this->assertEquals("(200/3)x^4", $c->toString());
        $this->assertEquals("(10/3)x^2", $a->toString());
        $this->assertEquals("20x^2", $b->toString());

        $d = new Polynomial();
        $d->addString("10x^2+5x");
        
        $e = new Polynomial();
        $e->addString("13x^2-10x+7x^5");
        $f = $d->mul($e);
        $this->assertEquals("-50x^2-35x^3+130x^4+35x^6+70x^7", $f->toString());
    }
}
