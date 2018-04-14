<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\Lagrange;
use \Math\MFunction;
use \Math\Polynomial;

class LagrangeTest extends Testcase{
    public function testPolynomials(){
        $l = new Lagrange(new MFunction("1"), 2, 0, 1);
        $pols = $l->getPolynomials();
    }
}
