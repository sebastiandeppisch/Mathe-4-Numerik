<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\ClosedNewtonCotesQuadrature;

class ClosedNewtonCotesQuadratureTest extends Testcase{
   public function testAlpha(){
       $integral = new ClosedNewtonCotesQuadrature([0, 1], [0, 1]);
       $this->assertEquals(new RationalNumber(1, 2), $integral->getAlpha(0));
       $this->assertEquals(new RationalNumber(1, 2), $integral->getAlpha(1));

       $integral = new ClosedNewtonCotesQuadrature([0, 1, 2], [0, 1, 2]);
       $this->assertEquals(new RationalNumber(1, 3), $integral->getAlpha(0));
       $this->assertEquals(new RationalNumber(4, 3), $integral->getAlpha(1));
       $this->assertEquals(new RationalNumber(1, 3), $integral->getAlpha(2));

       $integral = new ClosedNewtonCotesQuadrature([0, 1, 2, 3], [0, 1, 2, 3]);
       $this->assertEquals(new RationalNumber(3, 8), $integral->getAlpha(0));
       $this->assertEquals(new RationalNumber(9, 8), $integral->getAlpha(1));
       $this->assertEquals(new RationalNumber(9, 8), $integral->getAlpha(2));
       $this->assertEquals(new RationalNumber(3, 8), $integral->getAlpha(3));

       $integral = new ClosedNewtonCotesQuadrature([0, 1, 2, 3, 4], [0, 1, 2, 3, 4]);
       $this->assertEquals(new RationalNumber(14, 45), $integral->getAlpha(0));
       $this->assertEquals(new RationalNumber(64, 45), $integral->getAlpha(1));
       $this->assertEquals(new RationalNumber(24, 45), $integral->getAlpha(2));
       $this->assertEquals(new RationalNumber(64, 45), $integral->getAlpha(3));
       $this->assertEquals(new RationalNumber(14, 45), $integral->getAlpha(4));
   }
}

