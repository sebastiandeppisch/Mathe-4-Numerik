<?php
namespace Math;
abstract class Newton{
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
		if($x instanceof RationalNumber || $x instanceof FloatNumber){
			$x = $x->evaluate();
		}
		return (float) $this->func->evaluate($x);
	}

	public function getDegree(){
		return $this->degree;
	}

	public function getGamma($i){
		return $this->getF(0, $i);
	}

	public function getF($j, $jk=false){
		if($jk===false || $j===$jk){
			return $this->getY($j);
		}
		$f =  ($this->getF($j+1, $jk)-$this->getF($j, $jk-1))/($this->getX($jk)- $this->getX($j));
		return $f;
	}

	public function getPolynomial($i){
		$p = new Polynomial();
		$gamma = $this->getGamma($i);
		if($gamma instanceof RationalNumber){
			$gamma=$gamma->evaluate();
		}
		$p->addSummand(PolynomialSummand::new((float) $gamma));
		for($j=0;$j<$i;$j++){
			$p2 = new Polynomial();
			$p2->addSummand(PolynomialSummand::new(1, 1));
			$p2->addSummand(PolynomialSummand::new(-$this->getX($j)));
			$p=$p->mul($p2);
		}
		return $p;
	}

	public function getResult(){
		$result = new Polynomial();
		for($i=0;$i<=$this->degree;$i++){
			$p = $this->getPolynomial($i);
			$result->add($p);
		}
		return $result;
	}
}