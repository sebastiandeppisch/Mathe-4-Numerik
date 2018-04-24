<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\SystemOfLinearEquations;
use \Math\Matrix;
use \Math\Vector;
use \Math\RationalNumber;

class SystemOfLinearEquationsTest extends Testcase{
	public function testAddRow(){
		$m1 = new Matrix(3, 3);
		$m1->setArray([
			[1, 2, 3],
			[1, 1, 1],
			[3, 3, 1]
		]);

		$v1 = new Vector(3);
		$v1->setArray([2,2,0]);
		$a = new SystemOfLinearEquations($m1, $v1);
		$a->addRow(2, 0, new RationalNumber(-3));

		$m2 = new Matrix(3, 3);
		$m2->setArray([
			[1, 2, 3],
			[1, 1, 1],
			[0, -3, -8]
		]);

		$v2 = new Vector(3);
		$v2->setArray([2,2,-6]);
		$r = new SystemOfLinearEquations($m2, $v2);

		$this->assertEquals($r, $a);
	}

	public function testGetElliminateFactor(){
		$this->assertEquals(new RationalNumber(-3), SystemOfLinearEquations::getElliminateFactor(new RationalNumber(1), new RationalNumber(3)));
	}

	public function testElliminate(){
		$m1 = new Matrix(3, 3);
		$m1->setArray([
			[1, 2, 3],
			[1, 1, 1],
			[3, 3, 1]
		]);

		$v1 = new Vector(3);
		$v1->setArray([2,2,0]);
		$a = new SystemOfLinearEquations($m1, $v1);
		$a->elliminate();

		$m2 = new Matrix(3, 3);
		$m2->setArray([
			[1, 2, 3],
			[0, -1, -2],
			[0, 0, -2]
		]);

		$v2 = new Vector(3);
		$v2->setArray([2,0,-6]);
		$r = new SystemOfLinearEquations($m2, $v2);

		$this->assertEquals($r, $a);
	}
}
