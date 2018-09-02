<?php
namespace Math;
class GaussAlgorithm{

	private $a;

	private $b;

	public function __construct(Matrix $a, Vector $b){
		$this->a=$a;
		$this->b=$b;
	}
	
	public function getRS(Matrix $a, $s = null):array{
		$n = $a->getNRows();
		$r = 0;
		if($s === null ){
			$s = 0;
			$onlyRow=false;
		}else{
			$onlyRow=true;
			$r=$s;
		}
		$init = $s;
		for($i = $init; $i<$n; $i++){
			for($j = $init; $j<$n ;$j++){
				if($a->get($i, $j)->toFloat() > $a->get($r, $s)->toFloat()){
					if(!$onlyRow || ($onlyRow && $j==$s)){
						$r = $i;
						$s = $j;
					}
				}
			}
		}
		return [
			"r" => $r,
			"s" => $s
		];
	}

	public function exchangeRow(Matrix $a, $from, $to):Matrix{
		for($i = 0;$i<$a->getNRows();$i++){
			$temp = $a->get($from, $i);
			$a->set($from, $i, $a->get($to, $i));
			$a->set($to, $i, $temp);
		}
		return $a;
	}

	public function exchangeCol(Matrix $a, $from, $to):Matrix{
		for($i = 0;$i<$a->getNCols();$i++){
			$temp = $a->get($i, $from);
			$a->set($i, $from, $a->get($i, $to));
			$a->set($i, $to, $temp);
		}
		return $a;
	}

	public function solveLR($iterations = null):LRResult{
		$a = clone $this->a;
		$b = clone $this->b;
		$n = $a->getNRows();
		$l = new Matrix($a->getNRows(), $a->getNCols());
		$l->setZero();
		$p = new Matrix($a->getNRows(), $a->getNCols());
		$p->setIdentity();
		for($k = 0; $k<$n-1; $k++){
			if($iterations === 1){
				break;
			}
			$rs = $this->getRS($a, $k);
			$this->exchangeRow($a, $k, $rs["r"]);
			$this->exchangeRow($l, $k, $rs["r"]);
			$this->exchangeRow($p, $k, $rs["r"]);
			$this->exchangeCol($a, $k, $rs["s"]);
			$this->exchangeCol($l, $k, $rs["s"]);
			$this->exchangeCol($p, $k, $rs["s"]);
			$pivot = $a->get($k, $k)->copy();
			for($i = $k+1; $i<$n;$i++){
				$current = $a->get($i, $k)->copy();
				$x = $this->getElliminateFactor($pivot->copy(), $current->copy());
				$l->set($i, $k, $x);
				
				$this->addRow($a, $b, $i, $k, $x->copy()->negate());
			}
			if($iterations !== null && ($k+2)==$iterations){
				break;
			}
		}

		return new LRResult($l, $a, $b, $p);
	}


	static public function getElliminateFactor(Number $a, Number $b):Number{
		return $b->mul($a->reciprocal());
	}
	
	public function addRow(Matrix $matrix, Vector $vector, int $current, int $addLine, Number $mul=null){
		if($mul===null){
			$mul=new RationalNumber(1);
		}
		for($i=0;$i<$matrix->getNCols();$i++){
			$matrix->get($current, $i)->add($matrix->get($addLine, $i)->copy()->mul($mul));
		}
		$vector->get($current)->add($vector->get($addLine)->copy()->mul($mul));
	}
}

// cond(V ) v
class LRResult{
	private $l;
	private $r;
	private $c;
	private $p;

	public function __construct(Matrix $l=null, Matrix $r=null, Vector $c=null, Matrix $p=null){
		$this->l=$l;
		$this->r=$r;
		$this->c=$c;
		$this->p=$p;
	}

	public function getL(){
		return $this->l;
	}

	public function getR(){
		return $this->r;
	}

	public function getC(){
		return $this->c;
	}

	public function getP(){
		return $this->p;
	}

}