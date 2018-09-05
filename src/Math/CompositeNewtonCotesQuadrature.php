<?php
namespace Math;
use Math\Exception\WrongArgumentException;
class CompositeNewtonCotesQuadrature{
	private $y;

	private $a;
	private $b;

	private $n;

	private $closed=true;

	public function __construct($type, $a, $b, int $m, array $y){
		$this->a=Number::fromString($a);
		$this->b=Number::FromString($b);
		$this->y=Vector::fromArray($y);
		$this->m = $m;

		$type = explode("-",$type);
		if($type[0]=="open"){
			$this->closed=false;
		}
		$this->n=$type[1];

		if($this->getN() != $this->n*$m){
			//$message = sprintf("Die Anzahl der Y Werte N (%s) muss gleich m*n sein m(Teilintervalle): %s n(Grad): %s", $this->getN(), $m, $this->n);
			//throw new WrongArgumentException($message);
		}
	}

	static public function fromFunc($type, $a, $b, int $m, MFunction $func):CompositeNewtonCotesQuadrature{
		$y = [];
		$a = Number::fromString($a);
		$b = Number::fromString($b);
		$typeTemp = explode("-",$type);
		$h = $b->copy()->add($a->copy()->negate())->mul(new RationalNumber(1, $typeTemp[1]+1));
		$n = $m*$typeTemp[1];
		for($i=0;$i<=$n;$i++){
			$ih = $h->copy()->mul(new RationalNumber($i));
			$x = $a->copy()->add($ih);
			$y[$i]=$func->evaluate($x->evaluate());
		}
		return new CompositeNewtonCotesQuadrature($type, $a, $b, $m, $y);
	}

	public function getN(){
		return $this->y->getNRows();
	}
	
	public function getI(){
		$sum = new RationalNumber(0);
		$y = $this->chunkArray($this->y->getArray(), $this->m);
		$H = $this->b->copy()->add($this->a->negate())->mul(new RationalNumber(1, $this->m));
		for($i=0;$i<=$this->m-1;$i++){
			$a = $this->a->copy()->add($H->copy()->mul(new RationalNumber($i)));
			$b = $this->a->copy()->add($H->copy()->mul(new RationalNumber($i+1)));
			if($this->closed){
				$integral = new ClosedNewtonCotesQuadrature($a, $b, $y[$i]);
			}else{
				$integral = new OpenNewtonCotesQuadrature($a, $b, $y[$i]);
			}
			$sum = $sum->add($integral->getI());
		}
		return $sum;
	}

	public function chunkArray(array $all, int $nParts):array{
		$partLength = (int)(count($all)/ $nParts);
		$result = [];
		for($i=0;$i<$nParts;$i++){
			$result[$i]=[];
			for($j=0;$j<=$partLength;$j++){
				$result[$i][$j]=$all[$i*$partLength+$j];
			}
		}
		return $result;
	}

	public function getY(int $i):Number{
		return $this->y->get($i);
	}
}

// x x x x x