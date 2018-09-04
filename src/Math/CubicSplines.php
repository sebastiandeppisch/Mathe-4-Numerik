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
			return $this->xNodes[$n]->copy();
		}else{
			return Number::fromString($this->xNodes[$n]);
		}
	}

	public function getY($n):Number{
		if(!is_numeric($n)){
			$n = $n->evaluate();
		}
		if($this->yNodes[$n] instanceof Number){
			return $this->yNodes[$n]->copy();
		}else{
			return Number::fromString($this->yNodes[$n]);
		}
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

	private $sole=null;
	public function getSystemOfLinearEquation(){
		if($this->sole!==null){
			return $this->sole;
		}
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
				$matrix->set($i, $i-1, $this->getLambdaN());
				$matrix->set($i, $i, $this->getMuN());

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
		$system= new \Math\SystemOfLinearEquations($matrix, $vector, $variables);
		$this->sole=$system;
		return $system;
	}

	public function getBoundarys(){

	}

	public function getM(int $i):Number{
		$solution = $this->getSystemOfLinearEquation()->solve();
		return $solution[$i];
	}

	public function getD(int $i):Number{ //d_i = y_i - (h_i^2 / 6)*M_i
		$number = $this->getY($i)->copy();
		return $number->add($this->getH($i)->mul($this->getH($i))->mul(new RationalNumber(1, 6))->mul($this->getM($i))->negate());
	}

	public function getC(int $i):Number{//c_i = (y_(i+1) - d_i)/h_i - (h_i/6)*(M_(i+1))
		$y = $this->getY($i+1);
		$d = $this->getD($i);
		$h = $this->getH($i);
		$number =$y->add($d->negate())->mul($h->reciprocal()); //(y_(i+1) - d_i)/h_i
		return $number->add($this->getH($i)->mul(new RationalNumber(1, 6))->mul($this->getM($i+1))->negate()); // - h_i/6 (M_(i+1)

	}

	private $s=[];

	public function getS(int $i):Polynomial{
		if(array_key_exists($i, $this->s)){
			return $this->s[$i];
		}
		$s = new Polynomial();
		$xi1 = new Polynomial();
		$xi1->addSummand(new RPolynomialSummand($this->getX($i+1), 0)); //x_(i+1)
		$xi1->addSummand(new RPolynomialSummand(new RationalNumber(-1, 1), 1)); // -x
		$temp = $xi1->mul($xi1)->mul($xi1); // ()^3
		$temp->divRational($this->getH($i));
		$Mi = new Polynomial();
		$Mi->addSummand(new \Math\RPolynomialSummand($this->getM($i), 0));
		$temp = $temp->mul($Mi);
		$s->add($temp);

		$xi = new Polynomial();
		$xi->addSummand(new RPolynomialSummand($this->getX($i)->negate(), 0)); //x_(i)
		$xi->addSummand(new RPolynomialSummand(new RationalNumber(1, 1), 1)); // x
		$temp = $xi->mul($xi)->mul($xi);
		$temp->divRational($this->getH($i));
		$Mi1 = new Polynomial();
		$Mi1->addSummand(new \Math\RPolynomialSummand($this->getM($i+1), 0));
		$temp = $temp->mul($Mi1);
		$s->add($temp);

		$sixth = new Polynomial();
		$sixth->addSummand(new RPolynomialSummand(new RationalNumber(1, 6), 0));
		$s = $s->mul($sixth);
		
		$s->addSummand(new RPolynomialSummand($this->getC($i), 1));
		$s->addSummand(new RPolynomialSummand($this->getC($i)->mul($this->getX($i)->negate()), 0));
		$s->addSummand(new RPolynomialSummand($this->getD($i), 0));
		$this->s[$i]=$s;
		return $s;
	}
}