<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\NaturalCubicSplines;
use \Math\RationalNumber;
use \Math\Matrix;

class NaturalCubicSplinesTest extends Testcase{
    public function testParameter(){
        $splines = new NaturalCubicSplines([], []);
        $this->assertEquals(0, $splines->getB0()->evaluate());
        $this->assertEquals(0, $splines->getBN()->evaluate());

        $this->assertEquals(1, $splines->getMu0()->evaluate());
        $this->assertEquals(1, $splines->getMuN()->evaluate());

        $this->assertEquals(0, $splines->getLambda0()->evaluate());
        $this->assertEquals(0, $splines->getLambdaN()->evaluate());
    }

    public function testLinearEquationSystem(){
        $splines = new NaturalCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1]);

        $rMatrix = new Matrix(6, 6);
        $rMatrix->setArray([
            [1, 0, 0, 0, 0, 0],
            [1, 4, 1, 0, 0, 0],
            [0, 1, 4, 1, 0, 0],
            [0, 0, 1, 4, 1, 0],
            [0, 0, 0, 1, 4, 1],
            [0, 0, 0, 0, 0, 1]
        ]);
        $rMatrix->mulScalar(new RationalNumber(1, 6));
        $rMatrix->set(0, 0, 1);
        $rMatrix->set(5, 5, 1);

        $les = $splines->getSystemOfLinearEquation();

        $this->assertEquals($rMatrix, $les->getMatrix());
        $this->assertEquals(true, true);
    }

    public function testLinearEquationSystemFloat(){
        $splines = new NaturalCubicSplines([0.0, 1.0, 2.0, 3.0, 4.0, 5.0], [0.0, 1.0, -1.0, 2.0, 0.0, 1.0]);

        $rMatrix = new Matrix(6, 6);
        $rMatrix->setArray([
            [1, 0, 0, 0, 0, 0],
            [1, 4, 1, 0, 0, 0],
            [0, 1, 4, 1, 0, 0],
            [0, 0, 1, 4, 1, 0],
            [0, 0, 0, 1, 4, 1],
            [0, 0, 0, 0, 0, 1]
        ]);
        $rMatrix->mulScalar(new RationalNumber(1, 6));
        $rMatrix->set(0, 0, 1);
        $rMatrix->set(5, 5, 1);
        $rMatrix->toFloat();

        $les = $splines->getSystemOfLinearEquation();

        $this->assertEquals($rMatrix, $les->getMatrix()->toFloat());
        $this->assertEquals(true, true);
    }

    public function testD(){
        $splines = new NaturalCubicSplines([-1, 0, 1], [1, 2, 1]);
        $this->assertEquals(new RationalNumber(1), $splines->getD(0));
        $this->assertEquals(new RationalNumber(5, 2), $splines->getD(1));
    }

    public function testC(){
        $splines = new NaturalCubicSplines([-1, 0, 1], [1, 2, 1]);
        $this->assertEquals(new RationalNumber(2), $splines->getY(1));
        $this->assertEquals(new RationalNumber(3, 2), $splines->getC(0));
        $this->assertEquals(new RationalNumber(2), $splines->getY(1));
        $this->assertEquals(new RationalNumber(-3, 2), $splines->getC(1));
        $this->assertEquals(new RationalNumber(2), $splines->getY(1));
    }

    public function testM(){
        $splines = new NaturalCubicSplines([-1, 0, 1], [1, 2, 1]);
        $this->assertEquals(new RationalNumber(0), $splines->getM(0));
        $this->assertEquals(new RationalNumber(-3), $splines->getM(1));
        $this->assertEquals(new RationalNumber(0), $splines->getM(2));
    }

    public function testS(){
        $splines = new NaturalCubicSplines([-1, 0, 1], [1, 2, 1]);
        $this->assertEquals("2-(3/2)x^2-(1/2)x^3", $splines->getS(0)->toString());
        $this->assertEquals("2-(3/2)x^2+(1/2)x^3", $splines->getS(1)->toString());
    }

    public function testS2(){
        $splines = new NaturalCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1]);
        $this->assertEquals("(25/11)x-(14/11)x^3", $splines->getS(0)->toString());
        $this->assertEquals("-(51/11)+(178/11)x-(153/11)x^2+(37/11)x^3", $splines->getS(1)->toString());
        $this->assertEquals("(613/11)-(818/11)x+(345/11)x^2-(46/11)x^3", $splines->getS(2)->toString());
        $this->assertEquals("-148+(1423/11)x-(402/11)x^2+(37/11)x^3", $splines->getS(3)->toString());
        $this->assertEquals("(1636/11)-(1025/11)x+(210/11)x^2-(14/11)x^3", $splines->getS(4)->toString());
    }

    public function testConstructWithRationalNumber(){
        $splines = new NaturalCubicSplines([new RationalNumber(-1), new RationalNumber(0), new RationalNumber(1)], [new RationalNumber(1), new RationalNumber(2), new RationalNumber(1)]);
        $this->assertEquals(new RationalNumber(-3), $splines->getM(1));
    }
}
