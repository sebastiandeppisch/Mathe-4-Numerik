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
}
