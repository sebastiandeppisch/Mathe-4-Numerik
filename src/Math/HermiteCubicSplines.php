<?php
namespace Math;
class HermiteCubicSplines extends CubicSplines{

	private $derivativeA;

	private $derivativeB;

	public function __construct(array $xNodes, array $yNodes, Number $derivativeA, Number $derivativeB){
		parent::__construct($xNodes, $yNodes);
		$this->derivativeA=$derivativeA;
		$this->derivativeB=$derivativeB;
	}

	public function getDerivativeA():Number{
		return $this->derivativeA;
	}

	public function getDerivativeB():Number{
		return $this->derivativeB;
	}

	public function getMu0():Number{
		return $this->getH(0)->mul(new RationalNumber(1, 3)); 
	}

	public function getMuN():Number{
		return $this->getH($this->getDegree()-1)->mul(new RationalNumber(1, 3)); 
	}

	public function getLambda0():Number{
		return $this->getH(0)->mul(new RationalNumber(1, 6)); 
	}

	public function getLambdaN():Number{
		return $this->getH($this->getDegree()-1)->mul(new RationalNumber(1, 6)); 
	}

	public function getB0():Number{ //b_0 = (y_1-y_0)/h_0 - f'(a)
		$number = $this->getY(1)->copy()->add($this->getY(0)->negate()); //y_1 - y_0
		$number = $number->mul($this->getH(0)->reciprocal()); // $number/h_0
		return $number->add($this->getDerivativeA()->negate());
	}

	public function getBN():Number{ //b_n = f'(b) - (y_n - y_(n-1)) / h_(n-1)
		$number = $this->getY($this->getDegree())->add($this->getY($this->getDegree()-1)->negate());
		$number = $number->mul($this->getH($this->getDegree()-1)->reciprocal())->negate();
		return $number->add($this->getDerivativeB());
	}
}