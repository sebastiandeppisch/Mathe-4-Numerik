<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Vector;
use \Math\Matrix;
use \Math\RationalNumber;
use \Math\FloatNumber;

class VectorTest extends Testcase{
    public function testInit(){
        $v = new Vector(3);
        $v->set(0, new RationalNumber(1,1));
        $v->set(1, new RationalNumber(5,1));
        $v->set(2, new FloatNumber(42.0));
        $this->assertEquals(new FloatNumber(42.0), $v->get(2));
        $this->assertEquals(new RationalNumber(5, 1), $v->get(1));
        $this->assertEquals(new RationalNumber(1,1), $v->get(0));
    }

    public function testSetArray(){
        $v = new Vector(4);
        $v->setArray([
            new RationalNumber(1, 2),
            42,
            new FloatNumber(5),
            new RationalNumber(1,1)
        ]);
        $this->assertEquals(new RationalNumber(1,2), $v->get(0));
        $this->assertEquals(new RationalNumber(42,1), $v->get(1));
        $this->assertEquals(new FloatNumber(5), $v->get(2));
        $this->assertEquals(new RationalNumber(1), $v->get(3));
    }

    public function testGetArray(){
        $v = new Vector(3);
        $v->set(0, 42);
        $v->set(1, 7);
        $v->set(2, new FloatNumber(7.5));

        $result =[
            new RationalNumber(42),
            new RationalNumber(7),
            new FloatNumber(7.5)
        ];
        $this->assertEquals($result, $v->getArray());
    }

    public function testToMatrix(){
        $v = new Vector(3);
        $v->set(0, 42);
        $v->set(1, 7);
        $v->set(2, new FloatNumber(7.5));

        $m = new Matrix(3, 1);
        $m->setArray([
            [new RationalNumber(42)],
            [new RationalNumber(7)],
            [new FloatNumber(7.5)]
        ]);
        
        $this->assertEquals($m, $v->toMatrix());
    }

    public function testDotProduct(){
        $a = new Vector(3);
        $a->setArray([1,3,42]);

        $b = new Vector(3);
        $b->setArray([7,5,10]);
        $this->assertEquals(new RationalNumber(442), $a->dotProduct($b));
    }

    public function testMulScalar(){
        $v = new Vector(4);
        $v->setArray([
            1.0,
            42.0,
            7.5,
            0.5
        ]);

        $v->mulScalar(5.0);

        $r = new Vector(4);
        $r->setArray([
            5.0,
            210.0,
            37.5,
            2.5
        ]);
        $this->assertEquals($r, $v);
    }

    public function testCrossProduct(){
        $a = new Vector(3);
        $a->setArray([1, 2, 3]);

        $b = new Vector(3);
        $b->setArray([-7, 8, 9]);

        $r = new Vector(3);
        $r->setArray([-6, -30, 22]);
        
        $c = $a->crossProduct($b);
        
        $a2 = new Vector(3);
        $a2->setArray([1, 2, 3]);
        $this->assertEquals($a2, $a);

        $b2 = new Vector(3);
        $b2->setArray([-7, 8, 9]);
        $this->assertEquals($b2, $b);

        $this->assertEquals($r, $a->crossProduct($b));
    }

    public function testExchangeRows(){
        $v = new Vector(3);
        $v->setArray([
            1,
            42,
            7.5,
        ]);

        $r = new Vector(3);
        $r->setArray([
            1,
            7.5,
            42,
        ]);
        $v->exchangeRows(1, 2);
        $this->assertEquals($r, $v);
    }
}
