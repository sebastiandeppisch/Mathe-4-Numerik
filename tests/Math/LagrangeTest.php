<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Lagrange;
use \Math\LagrangeLinear;
use \Math\MFunction;
use \Math\Polynomial;

class LagrangeTest extends Testcase{

    public function testLFactor(){
        $l = new LagrangeLinear(new MFunction("1"), 2, 0, 2);
        $lf = $l->getLFactor(1,2);
        $p = new Polynomial();
        $p->addString("-x+2");
        $this->assertEquals($p, $lf);
    }

    public function testGetL(){
        $l = new LagrangeLinear(new MFunction("1"), 2, 0, 2);
        $p = $l->getL(0);

        $p0 = new Polynomial();
        $p0->addString("x^2-3x+2")->divNumber(2);
        $this->assertEquals($p0->toString(), $p->toString());
    }

    public function testPolynomials(){
        $l = new LagrangeLinear(new MFunction("1"), 2, 0, 2);
        $pols = $l->getPolynomials();
        $this->assertEquals(3, count($pols));
        $p0 = new Polynomial();
        $p0->addString("x^2-3x+2")->divNumber(2);
        $this->assertEquals($p0, $pols[0]);
    }
}
