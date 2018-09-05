<?php
namespace Math;
use Math\Exception\WrongArgumentException;
abstract class NewtonCotesQuadrature{
	private $y;

	private $a;
	private $b;

	protected $alphas=[];

	public function __construct($a, $b, array $y){
		$this->a=Number::fromString($a);
		$this->b=Number::FromString($b);
		$this->y=Vector::fromArray($y);
		if($this->getN() < 1){
			throw new WrongArgumentException("Es müssen mindestens 2 Werte angegeben werden");
		}
	}

	static public function fromFunc($a, $b, int $n, MFunction $func):NewtonCotesQuadrature{
		$y = [];
		$a = Number::fromString($a);
		$b = Number::fromString($b);
		$h = $b->copy()->add($a->copy()->negate())->mul(new RationalNumber(1, $n));
		for($i=0;$i<=$n;$i++){
			$ih = $h->copy()->mul(new RationalNumber($i));
			$x = $a->copy()->add($ih);
			$y[$i]=$func->evaluate($x->evaluate());
		}
		return new ClosedNewtonCotesQuadrature($a, $b, $y);
	}

	abstract public function getX(int $i):Number;

	public function getY(int $i){
		return $this->y->get($i);
	}

	public function getN():int{
		return $this->y->getNRows()-1;
	}

    public function getAlpha(int $i):Number{
        return Number::fromString($this->alphas[$this->getN()-1][$i]);
	}
	
	abstract public function getH():Number;

	public function getA():Number{
		return $this->a;
	}

	public function getB():Number{
		return $this->b;
	}
}