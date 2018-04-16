<?php
namespace Math;
class LagrangeChebyshev extends Lagrange{
	public function getX($n):float{
		return (($this->b-$this->a)/2)*cos(((2*$n+1)*pi())/(($n+1)*2))+($this->b+$this->a)/2;
	}

	public function getLFactor($i, $j){
		$part = new Polynomial();
		$x_j=$this->getX($j);
		$x_i=$this->getX($i);
		$part->addSummand(new FPolynomialSummand(1, 1));
		$part->addSummand(new FPolynomialSummand(-$x_j, 0));

		$p = new Polynomial();
		$p->addSummand(new FPolynomialSummand(1/($x_i-$x_j), 0));

		$part = $part->mul($p);
		return $part;
	}

	public function getL($i){
		$p = new Polynomial();
		$p->addSummand(new FPolynomialSummand(1, 0));
		for($j=0;$j<=$this->degree; $j++){
			if($j !== $i){
				$p = $p->mul($this->getLFactor($i, $j));
			}
		}
		return $p;
	} 
}