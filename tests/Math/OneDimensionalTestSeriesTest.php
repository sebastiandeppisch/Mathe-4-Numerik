<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\OneDimensionalTestSeries;

class NewtonManualTest extends Testcase{
    public function testDataIsSorted(){
        $s = new OneDimensionalTestSeries([new RationalNumber(5), -4, new FloatNumber(3)]);
        $s->getData();
        $this->assertEquals($s->getData(), [new RationalNumber(4), new FloatNumber(3), new RationalNumber(5)]);
    }

    public function testEmpiricalDistributionFunction(){
        
    }

    public function testHistogramm(){

    }

    public function testMedian(){

    }

    public function testArithemeticalAverage(){

    }

    public function testRange(){

    }

    public function testInterQuartileRange(){

    }

    public function testSampleVariance(){

    }

    public function testPQuantil(){

    }

    //TODO Empirische Streuung
}
