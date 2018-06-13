<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\OneDimensionalTestSeries;

use \Math\RationalNumber;
use \Math\FloatNumber;

class OneDimensionalTestSeriesTest extends Testcase{
    public function testDataIsSorted(){
        $s = new OneDimensionalTestSeries([new RationalNumber(5), -4, new FloatNumber(3)]);
        $s->getData();
        $this->assertEquals($s->getData(), [new RationalNumber(-4), new FloatNumber(3), new RationalNumber(5)]);
    }

    /*public function testEmpiricalDistributionFunction(){
        
    }

    public function testHistogramm(){

    }*/

    public function testMedian(){
        $s = new OneDimensionalTestSeries([1, 2, 10]);
        $this->assertEquals(new RationalNumber(2), $s->getMedian());

        $s = new OneDimensionalTestSeries([1, 2, 10, 100]);
        $this->assertEquals(new RationalNumber(2), $s->getMedian());
    }

    public function testArithmeticalAverage(){
        $s = new OneDimensionalTestSeries([1, 2, 10, 100]);
        $this->assertEquals(new RationalNumber(113, 4), $s->getArithmeticalAverage());

        $s = new OneDimensionalTestSeries([10, 93, 13, 15, 16]);
        $this->assertEquals(new RationalNumber(147, 5), $s->getArithmeticalAverage());
    }

    public function testRange(){
        $s = new OneDimensionalTestSeries([1, 2, 10, 100]);
        $this->assertEquals(new RationalNumber(99), $s->getRange());
    }

    public function testInterQuartileRange(){
        $s = new OneDimensionalTestSeries([25, 28, 4, 28, 19, 3, 9, 17, 29, 29]);
        $this->assertEquals(19.0, $s->getInterQuartileRange()->evaluate());
    }

    /*public function testSampleVariance(){

    }*/

    public function testPQuantil(){
        $s = new OneDimensionalTestSeries([82, 91, 12, 92 ,63, 9, 28, 55, 96, 97]);
        $this->assertEquals(63.0, $s->getPQuantil(0.50)->evaluate());
        $this->assertEquals(28.0, $s->getPQuantil(0.25)->evaluate());
        $this->assertEquals(92.0, $s->getPQuantil(0.72)->evaluate());

        $s = new OneDimensionalTestSeries([25, 28, 4, 28, 19, 3, 9, 17, 29, 29]);
        $this->assertEquals(9.0, $s->getPQuantil(0.25)->evaluate());
        $this->assertEquals(28.0, $s->getPQuantil(0.75)->evaluate());
    }

    public function testEmpiricalVariance(){
        $s = new OneDimensionalTestSeries([10, 9, 13, 15, 16]);
        $this->assertEquals(9.3, $s->getEmpiricalVariance()->evaluate());
    }

    public function testEmpirischeStreuung(){
        $s = new OneDimensionalTestSeries([10, 9, 13, 15, 16]);
        $this->assertEquals(3.05, $s->getEmpirischeStreuung()->evaluate(), '', 0.01);
    }

    public function testAlphaGestutztesMittel(){
        $s = new OneDimensionalTestSeries([5,30,29,15,25,5,13,28,24,29]);
        $this->assertEquals(21, $s->getAlphaGestutztesMittel(0.1)->evaluate());
    }

}
