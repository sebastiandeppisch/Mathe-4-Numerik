<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\HermiteCubicSplines;
use \Math\RationalNumber;
use \Math\Matrix;

class HermiteCubicSplinesTest extends Testcase{

    public function testLinearEquationSystem(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(-1), new RationalNumber(-1));

        $rMatrix = new Matrix(6, 6);
        $rMatrix->setArray([
            [2, 1, 0, 0, 0, 0],
            [1, 4, 1, 0, 0, 0],
            [0, 1, 4, 1, 0, 0],
            [0, 0, 1, 4, 1, 0],
            [0, 0, 0, 1, 4, 1],
            [0, 0, 0, 0, 1, 2]
        ]);
        $rMatrix->mulScalar(new RationalNumber(1, 6));

        $les = $splines->getSystemOfLinearEquation();

        $this->assertEquals($rMatrix, $les->getMatrix());
    }
}
