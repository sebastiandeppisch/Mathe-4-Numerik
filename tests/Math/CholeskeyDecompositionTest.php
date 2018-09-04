<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Algorithms\CholeskyDecomposition;
use \Math\Matrix;
use \Math\FloatNumber;
class CholeskyDecompositionTest extends Testcase{
    public function testGetL(){
        $a = new Matrix(3,3);
        $a->setArray([
            [1, 2, 1],
            [2, 5, 4],
            [1, 4, 14]
        ]);
        $cholesky = new CholeskyDecomposition($a);
        $this->assertEquals(new FloatNumber(1), $cholesky->getL(1,1));
        $this->assertEquals(new FloatNumber(2), $cholesky->getL(2,1));
        $this->assertEquals(new FloatNumber(1), $cholesky->getL(3,1));

        $this->assertEquals(new FloatNumber(1), $cholesky->getL(2,2));
        $this->assertEquals(new FloatNumber(2), $cholesky->getL(3,2));

        $this->assertEquals(new FloatNumber(3), $cholesky->getL(3,3));
    }

    public function testGetLMatrix(){
        $a = new Matrix(3,3);
        $a->setArray([
            [1, 2, 1],
            [2, 5, 4],
            [1, 4, 14]
        ]);

        $result = new Matrix(3, 3);
        $result->setArray([
            [1.0, 0, 0],
            [2.0, 1.0, 0], 
            [1.0, 2.0, 3.0]
        ]);
        $cholesky = new CholeskyDecomposition($a);
        $this->assertEquals($result, $cholesky->getLMatrix());
    }
}