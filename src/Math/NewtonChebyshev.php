<?php
namespace Math;
class NewtonChebyshev extends Lagrange{
	public function getX($n):float{
		return (($this->b-$this->a)/2)*cos(((2*$n+1)*pi())/(($n+1)*2))+($this->b+$this->a)/2;
	}

}