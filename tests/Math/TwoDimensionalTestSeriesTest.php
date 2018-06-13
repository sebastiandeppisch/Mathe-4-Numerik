<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\TwoDimensionalTestSeries;

use \Math\RationalNumber;
use \Math\FloatNumber;

class TwoDimensionalTestSeriesTest extends Testcase{
    public function testArithmeticalAverage(){
        $s = new TwoDimensionalTestSeries([1, 2, 10, 100], [10, 93, 13, 15, 16]);
        $this->assertEquals(new RationalNumber(113, 4), $s->getArithmeticalAverageX());
        $this->assertEquals(new RationalNumber(147, 5), $s->getArithmeticalAverageY());
	}

	public function testEmpiricalVariance(){
		$s = new TwoDimensionalTestSeries([10, 9, 13, 15, 16], [10, 9, 13, 15, 16]);
        $this->assertEquals(9.3, $s->getEmpiricalVarianceX()->evaluate());
        $this->assertEquals(9.3, $s->getEmpiricalVarianceY()->evaluate());
	}

	public function testEmpirischeStreuung(){
        $s = new TwoDimensionalTestSeries([10, 9, 13, 15, 16], [10, 9, 13, 15, 16]);
        
        $this->assertEquals(3.05, $s->getEmpirischeStreuungX()->evaluate(), '', 0.01);
        $this->assertEquals(3.05, $s->getEmpirischeStreuungY()->evaluate(), '', 0.01);
	}

	public function testEmpirischeKovarianz(){
        $s = new TwoDimensionalTestSeries([5,6,8,4,6,6,5,7,5,4], [2,1,4,1,2,0,2,3,3,1]);
        $this->assertEquals(0.844, $s->getEmpirischeKovarianz());
	}

	public function testEmpirischerKorrelationskoeffizient(){
        $s = new TwoDimensionalTestSeries([10,8,13,9,11,14,6,4,12,7,5], [8.04,6.95,7.58,8.81,8.33,9.96,7.24,4.24,10.84,4.82,5.68]); //https://de.wikipedia.org/wiki/Korrelationskoeffizient#Beispiel
        $this->assertEquals(0.816, $s->getEmpirischerKorrelationskoeffizient());
	}

}
