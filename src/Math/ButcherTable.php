<?php
namespace Math;

class ButcherTable{
	private $n;

	private $alphas;
	private $betas;
	private $gammas;
	public function __construct(int $n){
		$this->n=$n;
		for($i=0;$i<$n;$i++){
			$this->alphas=[];
		}
	}

	public static function fromArray(array $array):ButcherTable{
		$n = count($array)-1; // the array has the bettas as the last line => +1 
		$b = new ButcherTable($n);
		for($i=0;$i<=$n;$i++){
			for($j=0;$j<=$n;$j++){
				if($array[$i][$j] !== null){
					$value = RationalNumber::fromString($array[$i][$j]);
				}else{
					$value= new RationalNumber(0);
				}
				if($j==0){ // first col
					if($i!=$n){
						$b->gammas[$i]=$value;
					}	
				}elseif($i==$n){ //last row 
					$b->betas[$j-1]=$value;
				}else{
					$b->alphas[$i][$j-1]=$value;
				}
			}
		}
		return $b;
	}

	public function getAlpha($i, $j):Number{
		return $this->alphas[$i-1][$j-1];
	}

	public function getBeta($i):Number{
		return $this->betas[$i-1];
	}

	public function getGamma($i):Number{
		return $this->gammas[$i-1];
	}

	public function getConistency():int {
		$consistency = 0;

		$sum=new RationalNumber(0);
		for($i=1;$i<=$this->n;$i++){
			$sum = $sum->add($this->getBeta($i)->copy());
		}
		if(new RationalNumber(1) == $sum){
			$consistency = 1;
		}

		$sum = new RationalNumber(0);
		for($i=1;$i<=$this->n;$i++){
			$sum = $sum->add($this->getBeta($i)->copy()->mul($this->getGamma($i)));
		}
		if(new RationalNumber(1, 2) == $sum){
			$consistency = 2;
		}

		$sum1 = new RationalNumber(0);
		$sum2 = new RationalNumber(0);
		for($i=1;$i<=$this->n;$i++){
			$sum1=$sum1->add($this->getBeta($i)->copy()->mul($this->getGamma($i))->mul($this->getGamma($i)));
		}
		for($i=1;$i<=$this->n;$i++){
			for($j=1;$j<=$this->n;$j++){
				$sum2=$sum2->add($this->getBeta($i)->copy()->mul($this->getAlpha($i, $j)->copy()->mul($this->getGamma($j))->copy()));
			}
		}
		if(new RationalNumber(1, 3)== $sum1 && new RationalNumber(1, 6) == $sum2){
			$consistency = 3;
		}

		$sum1 = new RationalNumber(0);
		$sum2 = new RationalNumber(0);
		$sum3 = new RationalNumber(0);
		$sum4 = new RationalNumber(0);

		for($i=1;$i<=$this->n;$i++){
			$sum1=$sum1->add($this->getBeta($i)->copy()->mul($this->getGamma($i))->mul($this->getGamma($i))->mul($this->getGamma($i)));
		}
		for($i=1;$i<=$this->n;$i++){
			for($j=1;$j<=$this->n;$j++){
				$sum2=$sum2->add($this->getBeta($i)->copy()->mul($this->getAlpha($i, $j)->copy()->mul($this->getGamma($j))->copy()->mul($this->getGamma($i))->copy()));
			}
		}
		for($i=1;$i<=$this->n;$i++){
			for($j=1;$j<=$this->n;$j++){
				$sum3=$sum3->add($this->getBeta($i)->copy()->mul($this->getGamma($j))->mul($this->getGamma($j))->mul($this->getAlpha($i, $j)->copy()));
			}
		}
		for($i=1;$i<=$this->n;$i++){
			for($j=1;$j<=$this->n;$j++){
				for($k=1;$k<=$this->n;$k++){
					$sum4=$sum4->add($this->getBeta($i)->copy()->mul($this->getAlpha($i, $j)->copy())->mul($this->getAlpha($j, $k)->copy())->mul($this->getGamma($k)->copy()));
				}
			}
		}

		if(new RationalNumber(1, 4)== $sum1 && new RationalNumber(1, 8) == $sum2 && new RationalNumber(1, 12)== $sum3 && new RationalNumber(1, 24) == $sum4){
			$consistency = 4;
		}


		return $consistency;
	}

	public function hasConsistency($n):boolean{
		if($n === 1){
			$sum=new RationalNumber(0);
			for($i=1;$i<=$n;$i++){
				$sum = $sum->add($this->getBeta($i));
			}
			return new RationalNumber(1, 0) === $sum;
		}elseif($n === 2){

		}elseif($n === 3){

		}elseif($n === 4){

		}
	}
}