<?php
namespace Math;
class NaturalCubicSplines extends CubicSplines{

	public function getMu0():Number{
		return new RationalNumber(1);
	}

	public function getMuN():Number{
		return new RationalNumber(1);
	}

	public function getLambda0():Number{
		return new RationalNumber(0);
	}

	public function getLambdaN():Number{
		return new RationalNumber(0);
	}

	public function getB0():Number{
		return new RationalNumber(0);
	}

	public function getBN():Number{
		return new RationalNumber(0);
	}
}