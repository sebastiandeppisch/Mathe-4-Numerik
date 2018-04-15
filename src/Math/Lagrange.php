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

	public function getY($x){
		return $this->func->evaluate($x);
	}

	public function getLFactor($i, $j){
		$part = new Polynomial();
		$x_j=$this->getX($j);
		$x_i=$this->getX($i);
		$part->addSummand(new RPolynomialSummand(1, 1));
		$part->addSummand(new RPolynomialSummand(-$x_j, 0));
		$part->divNumber($x_i-$x_j);
		return $part;
	}

	public function getL($i){
		$p = new Polynomial();
		$p->addSummand(new RPolynomialSummand(1));
		for($j=0;$j<=$this->degree; $j++){
			if($j !== $i){
				$p = $p->mul($this->getLFactor($i, $j));
			}
		}
		return $p;
	} 	

	public function getPolynomials(){
		$polynomials=[];
		for($i=0;$i<=$this->degree;$i++){
			$polynomials[]=$this->getL($i);
		}
		return $polynomials;
	}

	public function getResult(){
		$result = new Polynomial();
		for($i=0;$i<=$this->degree;$i++){
			$l = $this->getL($i);
			$l = $l->toFloat();
			$p = new Polynomial();
			$p->addSummand(new FPolynomialSummand($this->getY($this->getX($i))));
			$l = $l->mul($p);
			$result->add($l);
		}
		return $result;
	}
}