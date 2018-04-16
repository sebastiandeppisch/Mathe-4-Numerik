<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\NewtonManual;
use \Math\MFunction;
use \Math\Polynomial;

class NewtonManualTest extends Testcase{
    public function testF(){
        $n = new NewtonManual(new MFunction("x"), [3, 1, 2, 0], [1, 2, 0, 1]);
        $this->assertEquals(1, $n->getF(0));
        $this->assertEquals(2, $n->getF(1));
        $this->assertEquals(0, $n->getF(2));
        $this->assertEquals(1, $n->getF(3));
    }

    public function testGamma(){
        $n = new NewtonManual(new MFunction("x"), [3, 1, 2, 0], [1, 2, 0, 1]);
        $this->assertEquals(1, $n->getGamma(0));
        $this->assertEquals(-0.5, $n->getGamma(1));
        $this->assertEquals(1.5, $n->getGamma(2));
        $this->assertEquals(1, $n->getGamma(3));
    }
}
