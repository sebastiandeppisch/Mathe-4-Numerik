<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\ClosedNewtonCotesQuadrature;
use \Math\RationalNumber;
use \Math\MFunction;
use \Math\CompositeNewtonCotesQuadrature;

class ClosedNewtonCotesQuadratureTest extends Testcase{
	public function testAlpha(){
		$integral = new ClosedNewtonCotesQuadrature(0, 1, [0, 1]);
		$this->assertEquals(new RationalNumber(1, 2), $integral->getAlpha(0));
		$this->assertEquals(new RationalNumber(1, 2), $integral->getAlpha(1));
		
		$integral = new ClosedNewtonCotesQuadrature(0, 2, [0, 1, 2]);
		$this->assertEquals(new RationalNumber(1, 3), $integral->getAlpha(0));
		$this->assertEquals(new RationalNumber(4, 3), $integral->getAlpha(1));
		$this->assertEquals(new RationalNumber(1, 3), $integral->getAlpha(2));
		
		$integral = new ClosedNewtonCotesQuadrature(0, 3, [0, 1, 2, 3]);
		$this->assertEquals(new RationalNumber(3, 8), $integral->getAlpha(0));
		$this->assertEquals(new RationalNumber(9, 8), $integral->getAlpha(1));
		$this->assertEquals(new RationalNumber(9, 8), $integral->getAlpha(2));
		$this->assertEquals(new RationalNumber(3, 8), $integral->getAlpha(3));
		
		$integral = new ClosedNewtonCotesQuadrature(0, 4, [0, 1, 2, 3, 4]);
		$this->assertEquals(new RationalNumber(14, 45), $integral->getAlpha(0));
		$this->assertEquals(new RationalNumber(64, 45), $integral->getAlpha(1));
		$this->assertEquals(new RationalNumber(24, 45), $integral->getAlpha(2));
		$this->assertEquals(new RationalNumber(64, 45), $integral->getAlpha(3));
		$this->assertEquals(new RationalNumber(14, 45), $integral->getAlpha(4));
	}
	
	public function testI(){
		$integral = new ClosedNewtonCotesQuadrature(-1, 1, ["1/2", "1/3", "1/4"]);
		$this->assertEquals(new RationalNumber(1), $integral->getH());
		$this->assertEquals(new RationalNumber(-1), $integral->getA());
		$this->assertEquals(new RationalNumber(1), $integral->getB());
		$this->assertEquals(new RationalNumber(25, 36), $integral->getI());
	}

	public function testIFloat(){
		$integral = new ClosedNewtonCotesQuadrature(-1, 1, [0.5, 0.375, 0.3, 0.25]);
		$this->assertEquals(new RationalNumber(2, 3), $integral->getH());
		$this->assertEquals(new RationalNumber(-1), $integral->getA());
		$this->assertEquals(new RationalNumber(1), $integral->getB());
		$this->assertEquals(3, $integral->getN());
		$this->assertEquals((new RationalNumber(111, 160))->evaluate(), $integral->getI()->evaluate());
	}
	
	public function testFromFunc(){
		$integral = ClosedNewtonCotesQuadrature::fromFunc(-1, 1, 3, new MFunction("1/(x+3)"));
		$this->assertEquals((new RationalNumber(111, 160))->toFloat(), $integral->getI());
	}


	/// Compositte 


	public function testCompositeNewtonCotesQuadrature(){
		$func = new MFunction("exp(-x^2)");

		$this->assertEquals(exp(-0.25), $func->evaluate(0.5));

		$integral = CompositeNewtonCotesQuadrature::fromFunc("closed-1", 0, 1, 2,  $func);
		$this->assertEquals(1, $integral->getY(0)->evaluate());
		$this->assertEquals(exp(-0.25), $integral->getY(1)->evaluate());
		$this->assertEquals(exp(-1), $integral->getY(2)->evaluate());
		$this->assertEquals(0.7314, round($integral->getI()->evaluate(), 4));
	}

/*	public function testChunkArray(){
		$func = new MFunction("exp(-x^2)");
		$integral = CompositeNewtonCotesQuadrature::fromFunc("closed-1", 0, 1, 2,  $func);
		$this->assertEquals([[1,2,3], [3,4,5], [5,6,7]], $integral->chunkArray([1,2,3,4,5,6,7], 3));
	}*/
}

