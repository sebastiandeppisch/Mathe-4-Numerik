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
}
