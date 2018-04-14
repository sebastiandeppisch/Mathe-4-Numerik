<?php
namespace Math;
class Lagrange{
	private $func;

	private $degree;

	private $a;

	private $b;
	public function __construct(MFunction $func, $degree, $a, $b){
		$this->func = $func;
		$this->degree=$degree;
		$this->a=$a;
		$this->b=$b;
	}
	public function getX($n){
		return $n;
	}

	public function getL($i){
		$p = new Polynomial();
		for($j=0;$j<$this->degree; $j++){
			if($j !== $i){

				$x_j=$this->getX($j);
				$x_i=$this->getX($i);

				$part = new Polynomial();
				$part->addSummand(new PolynomialSummand(1, 1));
				$part->addSummand(new PolynomialSummand(-$x_j, 0));
				//$part->divNumber($x_i-$x_j);
				$p = $p->mul($part);
			}
		}
	} 	

	public function getPolynomials(){
		$polynomials=[];
		for($i=0;$i<$this->degree;$i++){
			$polynomials[]=$this->getL($i);
		}
		return $polynomials;
	}
}