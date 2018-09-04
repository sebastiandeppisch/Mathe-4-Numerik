<?php
namespace Math;

use Math\Exception\DivisionNullException;
class RationalNumber extends Number{
	private $p;

	private $q;
	public function __construct(int $p, int $q=1){
		$this->setP($p);
		$this->setQ($q);
	}

	protected function addRational(RationalNumber $rhs):RationalNumber{
		$lcm = $this->lcm($this->getQ(), $rhs->getQ());
		$this->setP($this->getP()*($lcm/$this->getQ()) + $rhs->getP()*($lcm / $rhs->getQ()));
		$this->setQ($lcm);
		$this->reduce();
		return $this;
	}

	protected function mulRational(RationalNumber $rhs):RationalNumber{
		$this->setP($this->getP()*$rhs->getP());
		$this->setQ($this->getQ()*$rhs->getQ());
		$this->reduce();
		return $this;
	}

	public function getP(){
		return $this->p;
	}

	public function getQ(){
		return $this->q;
	}

	public function setP($p){
		$this->p=(int)$p;
	}

	public function setQ($q){
		if($q === 0 && $this->getP() !== 0){
			throw new DivisionNullException();
		}
		if($q < 0){
			$q = $q*-1;
			$this->p=$this->p*-1;
		}
		$this->q=(int)$q;
	}

	public function toHTML($signed = true){
		$p =($signed)?$this->p:abs($this->p);
		if($this->q == 1){
			return '<div class="rationalnumber">'.$p.'</div>';
		}
		return '<div class="rationalnumber"><div class="text-center">'.$p.'</div><div class="rationalnumber-fractionline"></div><div class="text-center">'.$this->q.'</div></div>';
	}

	public function evaluate():float{
		return $this->p/$this->q;
	}

	public function lcm(int $a, int $b): int{
		if($a === 0 || $b === 0){
			return 0;
		}
		return ($a * $b) / $this->gcd($a, $b);
	}

	public function gcd($a, $b){
		if($a < 1 || $b < 1){
			throw new \Exception("a or b less than 1");
		}
		$r = 0;
		do{
			$r = $a % $b;
			$a = $b;
			$b = $r;
		}while($b != 0);
		return $a;
	}
	
	public function factorization(int $a): array{
		$result = array();
		if($a == 1){
			return [1];
		}
		for($i=2;$i<=$a; $i++){
			while(($a % $i) == 0){
				$result[]=$i;
				$a=$a/$i;
			}
		}
		return $result;
	}

	public function toString($brackets=false){
		if($this->q === 1 || $this->p === 0){
			return sprintf("%s", $this->p, $this->q);
		}
		if($brackets){
			if($this->p < 0){
				return sprintf("-(%s/%s)", -$this->p, $this->q);
			}
			return sprintf("(%s/%s)", $this->p, $this->q);
		}
		return sprintf("%s/%s", $this->p, $this->q);
	}

	public function reduce(){
		if($this->p !== 0){
			$gcd = $this->gcd(abs($this->p), abs($this->q));
			$this->p=$this->p/$gcd;
			$this->q=$this->q/$gcd;
		}else{
			$this->q=1;
		}
	}

	public function copy(){
		return  new RationalNumber($this->p, $this->q);
	}

	static public function fromString($number):Number{
		if($number instanceof RationalNumber){
			return $number;
		}
		$number = explode("/", $number);
		$p = (int)$number[0];
		if(isset($number[1])){
			$q =(int) $number[1];
		}else{
			$q=1;
		}
		return new RationalNumber($p, $q);
	}

	public function reciprocal(){
		return new RationalNumber($this->getQ(), $this->getP());
	}

	public function negate(){
		return new RationalNumber(-1*$this->getP(), $this->getQ());
	}

	public function __toString(){
		return $this->toString();
	}
}