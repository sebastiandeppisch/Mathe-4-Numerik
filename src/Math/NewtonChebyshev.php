<?php
namespace Math;
class NewtonChebyshev extends Newton{
	public function getX($n):float{
		return ((($this->b-$this->a)/2)*cos((pi()/2)*((2*$n+1))/(($n+1))))+(($this->b+$this->a)/2);
	}

}