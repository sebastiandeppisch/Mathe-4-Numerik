<?php
namespace Math;
abstract class Lagrange{
	protected $func;

	protected $degree;

	protected $a;

	protected $b;
	public function __construct(MFunction $func, $degree, $a, $b){
		$this->func = $func;
		$this->degree=$degree;
		$this->a=$a;
		$this->b=$b;
	}

	abstract public function getX($n);

	public function getY($x){
		if($x instanceof RationalNumber){
			$x = $x->evaluate();
		}
		return $this->func->evaluate($x);
	}

	public function getLFactor($i, $j){
		$part = new Polynomial();
		$x_j=$this->getX($j);
		$x_i=$this->getX($i);
		$x_jMinus=$x_j->mul(new RationalNumber(-1, 1));
		$part->addSummand(new RPolynomialSummand(1, 1));
		$part->addSummand(new RPolynomialSummand($x_jMinus, 0));
		$part = $part->divRational($x_i->add($x_jMinus));
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