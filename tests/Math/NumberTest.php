<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\RationalNumber;
use \Math\Number;
use \Math\FloatNumber;

class NumberTest extends Testcase{
	public function testFromString(){
		$n = Number::fromString("-42.7");
		$this->assertEquals(new FloatNumber(-42.7), $n);

		$n = Number::fromString("32");
		$this->assertEquals(new RationalNumber(32), $n);

		$n = Number::fromString("-1/2");
		$this->assertEquals(new RationalNumber(-1, 2), $n);

		$n = Number::fromString("234.0");
		$this->assertEquals(new FloatNumber(234.0), $n);
	}
}
