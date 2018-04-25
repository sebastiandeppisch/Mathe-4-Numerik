<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Matrix;
use \Math\RationalNumber;
use \Math\FloatNumber;

class MatrixTest extends Testcase{
    public function testInit(){
        $m = new Matrix(3, 2);
        $m->set(0, 0, new RationalNumber(1,1));
        $m->set(1, 1, new RationalNumber(5,1));
        $m->set(2, 0, new FloatNumber(42.0));
        $this->assertEquals(new FloatNumber(42.0), $m->get(2, 0));
        $this->assertEquals(new RationalNumber(5, 1), $m->get(1, 1));
        $this->assertEquals(new RationalNumber(1,1), $m->get(0,0));
    }

    public function testSetArray(){
        $m = new Matrix(3,2);
        $m->setArray(
            [
                [
                    new RationalNumber(1, 2),
                    42
                ],
                [
                    new FloatNumber(5),
                    new RationalNumber(1,1)
                ],
                [
                    7.5,
                    13
                ]
            ]
        );
        $this->assertEquals(new RationalNumber(1,2), $m->get(0, 0));
        $this->assertEquals(new RationalNumber(42,1), $m->get(0, 1));

        $this->assertEquals(new FloatNumber(5), $m->get(1, 0));
        $this->assertEquals(new RationalNumber(1,1), $m->get(1, 1));

        $this->assertEquals(new FloatNumber(7.5), $m->get(2, 0));
        $this->assertEquals(new RationalNumber(13), $m->get(2, 1));
    }

    public function testgetArray(){
        $m = new Matrix(2, 2);
        $m->set(0, 0, 10);
        $m->set(0, 1, 8);
        $m->set(1, 0, 9);
        $m->set(1, 1, 6);

        $result =[
            [new RationalNumber(10), new RationalNumber(8)],
            [new RationalNumber(9), new RationalNumber(6)]
        ];
        $this->assertEquals($result, $m->getArray());
    }

    public function testTransposed(){
        $m = new Matrix(3, 2);
        $m->setArray(
            [
                [1,2],
                [3, 4],
                [5, 6]
            ]
        );
        $transposed = $m->getTransposed();

        $result = new Matrix(2, 3);
        $result->setArray(
            [
                [1,3,5],
                [2,4,6]
            ]
        );
        $this->assertEquals(3, $m->getNRows());
        $this->assertEquals(2, $m->getNCols());
        $this->assertEquals(2, $transposed->getNRows());
        $this->assertEquals(3, $transposed->getNCols());
        $this->assertEquals($result, $transposed);
    }

    /**
     * @expectedException   \Exception
     */
    public function testMatrixMultiplicationThrowsException(){
        $m1 = new Matrix(3, 4);
        $m2 = new Matrix(5, 6);
        $m1->mul($m2);
    }

    public function testMulC(){
        $a = new Matrix(1, 3);
        $a->setArray([
            [1, 1, 1]
        ]);
        $b = new Matrix(3, 1);
        $b->setArray([
            [1],
            [1],
            [1]
        ]);

        $this->assertEquals(3.0, Matrix::getC($a, $b, 0 , 0)->evaluate());

        $a = new Matrix(1, 3);
        $a->setArray([
            [3, 2, 1]
        ]);
        $b = new Matrix(3, 1);
        $b->setArray([
            [2],
            [1],
            [0]
        ]);

        $this->assertEquals(8.0, Matrix::getC($a, $b, 0 , 0)->evaluate());

        $a = new Matrix(2, 3);
        $a->setArray([
            [234324, 4324, 6456],
            [3, 2, 1]
        ]);
        $b = new Matrix(3, 2);
        $b->setArray([
            [2, 234234],
            [1, 6432],
            [0, 9687]
        ]);

        $this->assertEquals(8.0, Matrix::getC($a, $b, 1 , 0)->evaluate());

        $a = new Matrix(2, 3);
        $a->setArray([
            [3, 2, 1],
            [234324, 4324, 6456]
        ]);
        $b = new Matrix(3, 2);
        $b->setArray([
            [234234, 2],
            [3457, 1],
            [8764, 0]
        ]);

        $this->assertEquals(8.0, Matrix::getC($a, $b, 0, 1)->evaluate());
    }

    public function testMul(){
        $a = new Matrix(2, 3);
        $a->setArray([
            [1, 2, 3],
            [3, 1, 1]
        ]);
        $b = new Matrix(3, 2);
        $b->setArray([
            [2, 1],
            [1, 2],
            [2, 1]
        ]);
        $c = $a->mul($b);
        
        $result = new Matrix(2,2);
        $result->setArray([
            [10, 8],
            [9, 6]
        ]);
        $this->assertEquals($result, $c);
    }

    public function testMulScalar(){
        $a = new Matrix(2, 3);
        $a->setArray([
            [1, 2, 3],
            [3, 1, 1]
        ]);
        $a->mulScalar(5);

        $result = new Matrix(2, 3);
        $result->setArray([
            [5, 10, 15],
            [15, 5, 5]
        ]);
        $this->assertEquals($result, $a);
    }

    public function testMulScalarRow(){
        $a = new Matrix(2, 3);
        $a->setArray([
            [1, 2, 3],
            [3, 1, 1]
        ]);
        $a->mulScalarRow(1,5);

        $result = new Matrix(2, 3);
        $result->setArray([
            [1, 2, 3],
            [15, 5, 5]
        ]);
        $this->assertEquals($result, $a);
    }

    public function testExchangeRows(){
        $a = new Matrix(2, 3);
        $a->setArray([
            [1, 2, 3],
            [3, 1, 1]
        ]);

        $result = new Matrix(2, 3);
        $result->setArray([
            [3, 1, 1],
            [1, 2, 3]
        ]);
        $a->exchangeRows(0, 1);
        $this->assertEquals($result, $a);
    }

    public function testSetZero(){
        $m = new Matrix(2, 2);
        $m->setZero();
        $rm = new Matrix(2, 2);
        $rm->setArray([
            [0, 0],
            [0, 0]
        ]);
        $this->assertEquals($rm, $m);
    }
}
