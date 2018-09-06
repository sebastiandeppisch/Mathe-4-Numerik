<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\GaussAlgorithm;
use Math\Matrix;
use Math\Vector;
use Math\RationalNumber;

class GausLRTest extends Testcase{

   /* public function testLR(){
		$a = Matrix::fromArray([
			[1, 2, -1],
			[2, -2, 4],
			[2, 1, -2]
		]);
		$b = Vector::fromArray([2, 10, -2]);
		$gauss = new GaussAlgorithm($a, $b);

		$result = $gauss->solveLR();
*/
		/*$this->assertEquals(Matrix::fromArray([
			[1, 2, -1],
			[2, -2, 4],
			[2, 1, -2]
		]), $a);
		$this->assertEquals(Vector::fromArray([1, 10, -2]), $b);
*/

	/*	$this->assertEquals(Matrix::fromArray([
			[1, 0, 0],
			["-1/2", 1, 0],
			["-1/4", "1/2", 1]
		]), $result->getL());*/
/*
		$this->assertEquals(Matrix::fromArray([
			[2, -2, 3],
			[0, 3, -3],
			[0, 0, -3]
		]), $result->getR());

		$this->assertEquals(Matrix::fromArray([
			[0, 1, 0],
			[1, 0, 0],
			[0, 0, 1]
		]), $result->getP());

		$this->assertEquals(Matrix::fromArray([
			[1, 0, 0],
			[0, 1, 0],
			[0, 0, 1]
		]), $result->getPi());

		$result = $gauss->solveLR(1);

		$this->assertEquals(Matrix::fromArray([
			[0, 1, 0],
			[1, 0, 0],
			[0, 0, 1]
		]), $result->getPi());*/
	//}

	public function testAddRow(){
		$a = Matrix::fromArray([
			[1, 1, 0, 1],
			[1, 2, 1, 0],
			[0, 1, 2, 1],
			[1, 0, 1, 2]
		]);
		$b = Vector::fromArray([2, 5, 1, -1]);
		$gauss = new GaussAlgorithm($a, $b);

		$gauss->addRow($a, $b, 1, 0, new RationalNumber(-1));
		$this->assertEquals(Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 1, 2, 1],
			[1, 0, 1, 2]
		]), $a);

		$gauss->addRow($a, $b, 2, 0, new RationalNumber(0));
		$this->assertEquals(Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 1, 2, 1],
			[1, 0, 1, 2]
		]), $a);

		$gauss->addRow($a, $b, 3, 0, new RationalNumber(-1));
		$this->assertEquals(Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 1, 2, 1],
			[0, -1, 1, 1]
		]), $a);
	}

	public function testLR(){
		$a = Matrix::fromArray([
			[1, 1, 0, 1],
			[1, 2, 1, 0],
			[0, 1, 2, 1],
			[1, 0, 1, 2]
		]);
		$b = Vector::fromArray([2, 5, 1, -1]);
		$gauss = new GaussAlgorithm($a, $b);

		$result = $gauss->solveLR(1);

		$this->assertEquals(Matrix::fromArray([
			[0, 0, 0, 0],
			[0, 0, 0, 0],
			[0, 0, 0, 0],
			[0, 0, 0, 0]
		]), $result->getL());

		$result = $gauss->solveLR(2);

		$this->assertEquals(Matrix::fromArray([
			[0, 0, 0, 0],
			[1, 0, 0, 0],
			[0, 0, 0, 0],
			[1, 0, 0, 0]
		]), $result->getL());

		$this->assertEquals(Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 1, 2, 1],
			[0, -1, 1, 1]
		]), $result->getR());

		$result = $gauss->solveLR(3);
		$this->assertEquals(Matrix::fromArray([
			[0, 0, 0, 0],
			[1, 0, 0, 0],
			[0, 1, 0, 0],
			[1, -1, 0, 0]
		]), $result->getL());
		$this->assertEquals(Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 0, 1, 2],
			[0, 0, 2, 0]
		]), $result->getR());



		$result = $gauss->solveLR();
		$this->assertEquals(Matrix::fromArray([
			[0, 0, 0, 0],
			[1, 0, 0, 0],
			[1, -1, 0, 0],
			[0, 1, "1/2", 0]
		]), $result->getL());
		$this->assertEquals(Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 0, 2, 0],
			[0, 0, 0, 2]
		]), $result->getR());
	}

	public function testGetRS(){
		$a = Matrix::fromArray([
			[1, 2, -1],
			[2, -2, 4],
			[2, 1, -2]
		]);
		$b = Vector::fromArray([1, 10, -2]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(["r" => 1, "s" => 2], $gauss->getRS($a));

		$a = Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 1, 2, 1],
			[0, -1, 1, 1]
		]);
		$b = Vector::fromArray([1, 10, -2, 0]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(["r" => 2, "s" => 2], $gauss->getRS($a));

		$a = Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 0, 1, 2],
			[0, 0, 2, 0]
		]);
		$b = Vector::fromArray([1, 10, -2, 0]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(["r" => 3, "s" => 2], $gauss->getRS($a, 2));

		$a = Matrix::fromArray([
			[1, 1, 0, 1],
			[1, 2, 1, 0],
			[0, 1, 2, 1],
			[1, 0, 1, 2]
		]);
		$b = Vector::fromArray([1, 10, -2, 0]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(["r" => 0, "s" => 0], $gauss->getRS($a, 0));

		$a = Matrix::fromArray([
			[1, 1, 0, 1],
			[0, 1, 1, -1],
			[0, 1, 2, 1],
			[0, -1, 1, 1]
		]);
		$b = Vector::fromArray([1, 10, -2, 0]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(["r" => 1, "s" => 1], $gauss->getRS($a, 1));


		
	}

	public function testExchangeRow(){
		$a = Matrix::fromArray([
			[1, 2, -1],
			[2, -2, 4],
			[2, 1, -2]
		]);
		$b = Vector::fromArray([1, 10, -2]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(Matrix::fromArray([
			[1, 2, -1],
			[2, 1, -2],
			[2, -2, 4]
		]), $gauss->exchangeRow($a, 1, 2));
	}

	public function testExChangeCol(){
		$a = Matrix::fromArray([
			[1, 2, -1],
			[2, -2, 4],
			[2, 1, -2]
		]);
		$b = Vector::fromArray([1, 10, -2]);
		$gauss = new GaussAlgorithm($a, $b);
		$this->assertEquals(Matrix::fromArray([
			[2, 1, -1],
			[-2, 2, 4],
			[1, 2, -2]
		]), $gauss->exchangeCol($a, 0, 1));
	}
}
