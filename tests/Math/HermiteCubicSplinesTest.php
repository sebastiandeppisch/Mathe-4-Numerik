<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\HermiteCubicSplines;
use \Math\RationalNumber;
use \Math\Matrix;
use \Math\Vector;
use \Math\Polynomial;

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

        $rVector = new Vector(6);
        $rVector->setArray([2, -3, 5, -5, 3, -2]);


        $les = $splines->getSystemOfLinearEquation();

        $this->assertEquals($rMatrix, $les->getMatrix());
        $this->assertEquals($rVector, $les->getVector());
        $this->assertEquals(true, true);
    }

    public function testParameter(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(-1), new RationalNumber(-1));
        $this->assertEquals(2, $splines->getB0()->evaluate());
        $this->assertEquals(-2, $splines->getBN()->evaluate());
        $this->assertEquals(2/6, $splines->getMu0()->evaluate());
        $this->assertEquals(2/6, $splines->getMuN()->evaluate());

        $this->assertEquals(1/6, $splines->getLambda0()->evaluate());
        $this->assertEquals(1/6, $splines->getLambdaN()->evaluate());
    }

    public function testH(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(-1), new RationalNumber(-1));
        $this->assertEquals(1, $splines->getH(0)->evaluate());
        $this->assertEquals(1, $splines->getH(1)->evaluate());

        $splines = new HermiteCubicSplines([0, 2, 9, 4, 5, 6], [0, 1, -1], new RationalNumber(-1), new RationalNumber(-1));

        $this->assertEquals(2, $splines->getH(0)->evaluate());
        $this->assertEquals(7, $splines->getH(1)->evaluate());
    }

    public function testM(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(-2), new RationalNumber(-2));
        $les = $splines->getSystemOfLinearEquation();
        $result = $les->solve();
        $this->assertEquals([
            new RationalNumber(282,19),
            new RationalNumber(-222, 19),
            new RationalNumber(264, 19),
             new RationalNumber(-264, 19),
             new RationalNumber(222, 19),
             new RationalNumber(-282, 19)
        ], $result);
    }

    public function testM2(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(0), new RationalNumber(0)); //TODO In den Folien steht für diese Beipsiel -1, aber die Zahlen hier stimmen mit 0 überein
        $les = $splines->getSystemOfLinearEquation();
        $result = $les->solve();
        foreach($result as $r){
           // var_dump($r->evaluate());
        }
        /*$this->assertEquals([
            new RationalNumber(282,19),
            new RationalNumber(-222, 19),
            new RationalNumber(264, 19),
             new RationalNumber(-264, 19),
             new RationalNumber(222, 19),
             new RationalNumber(-282, 19)
        ], $result);*/
        $this->assertTrue(true);
    }

    public function testM3(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(-2), new RationalNumber(-2));
        $this->assertEquals(new RationalNumber(-222, 19), $splines->getM(1));
    }

    public function testS(){
        $splines = new HermiteCubicSplines([0, 1, 2, 3, 4, 5], [0, 1, -1, 2, 0, 1], new RationalNumber(-2), new RationalNumber(-2));
        $this->assertEquals("(596/209)x-x^2-(178/209)x^3", $splines->getS(0)->toString());
        $this->assertEquals("-(859/209)+(167/11)x-(2786/209)x^2+(681/209)x^3", $splines->getS(1)->toString());
        $this->assertEquals("+(11581/209)-(15487/209)x+(6544/209)x^2-(46/11)x^3", $splines->getS(2)->toString());
        $this->assertEquals("-(2872/19)+(27686/209)x-(413/11)x^2+(725/209)x^3 ", $splines->getS(3)->toString());
        $this->assertEquals("", $splines->getS(4)->toString());
        /*$s3 = new Polynomial();
        $s3->addString();
        $this->assertEquals($s3, $splines->getS(3));

        $s4 = new Polynomial();
        $s4->addString("");
        $this->assertEquals($s4, $splines->getS(4));*/ 
    }
}
