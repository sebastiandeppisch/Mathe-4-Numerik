<?php
namespace Math;

abstract class CubicSplines{
	private $xNodes;

	private $yNodes;

	private $degree;

	public function __construct(array $xNodes, array $yNodes){
		$this->xNodes=$xNodes;
		$this->yNodes=$yNodes;
		$this->degree=count($xNodes)-1;
	}

	public function getX($n):Number{
		if(!is_numeric($n)){
			$n = $n->evaluate();
		}
		if($this->xNodes[$n] instanceof Number){
			return $this->xNodes[$n];
		}
		if(is_int($this->xNodes[$n])){
			return new RationalNumber($this->xNodes[$n]);
		}
		return $this->xNodes[$n];
	}

	public function getY($n):Number{
		if(!is_numeric($n)){
			$n = $n->evaluate();
		}
		if($this->yNodes[$n] instanceof Number){
			return $this->yNodes[$n];
		}
		if(is_int($this->yNodes[$n])){
			return new RationalNumber($this->yNodes[$n]);
		}
		return $this->yNodes[$n];
	}

	public function getDegree():int{
		return $this->degree;
	}

	abstract public function getMu0():Number;

	abstract public function getMuN():Number;

	abstract public function getLambda0():Number;

	abstract public function getLambdaN():Number;

	abstract public function getB0():Number;

	abstract public function getBN():Number;

	public function getH(int $i):Number{
		$xi1 = $this->getX($i+1);
		$xi =  $this->getX($i);
		return $xi1->add($xi->negate());
	}

	public function getSystemOfLinearEquation(){
		$matrix = new Matrix($this->getDegree()+1, $this->getDegree()+1);
		$matrix->setZero();
		$vector = new Vector($this->getDegree()+1);

		$variables = [];

		for($i=0;$i<=$this->getDegree();$i++){
			if($i === 0){
				$matrix->set($i, 0, $this->getMu0());
				$matrix->set($i, 1, $this->getLambda0());

				$vector->set($i, $this->getB0());
			}elseif($i === $this->getDegree()){
				$matrix->set($i, $i-1, $this->getMuN());
				$matrix->set($i, $i, $this->getLambdaN());

				$vector->set($i, $this->getBN());
			}else{
				$matrix->set($i, $i-1, $this->getH($i-1)->mul(new RationalNumber(1, 6))); //h_(i-1) / 6
				$matrix->set($i, $i, $this->getH($i-1)->copy()->add($this->getH($i))->mul(new RationalNumber(1, 3))); //(h_(i-1)+h_i ) / 3
				$matrix->set($i, $i+1, $this->getH($i)->mul(new RationalNumber(1, 6))); //h_i / 6

				$a = $this->getY($i+1)->copy()->add($this->getY($i)->negate())->mul($this->getH($i)->reciprocal()); //(y_(i+1) - y_i) / h_i
				$b = $this->getY($i)->copy()->add($this->getY($i-1)->negate())->mul($this->getH($i-1)->reciprocal());// (y_i - y_(i-1)) / h_(i-1)
				$vector->set($i, $a->add($b->negate())); //$a - $b
			}
			$variables[]="M_".$i;
		}
		return new \Math\SystemOfLinearEquations($matrix, $vector, $variables);
	}

	public function getBoundarys(){

	}
}