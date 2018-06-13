<?php
namespace Math;
class OneDimensionalTestSeries{
	private $data;
	public function __construct(array $data){
		foreach($data as &$number){
			$number = $this->convertNumber($number);
		}
		usort($data, function(Number $a, $b){
			$a=$a->evaluate();
			$b=$b->evaluate();
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? -1 : 1;
		});
		$this->data=$data;
	}

	public function getData(){
		return $this->data;
	}

	public function getN(){
		return count($this->data);
	}

	public function get($i){
		return $this->data[$i-1];
	}

	public function convertNumber($number):Number{
		if($number instanceof Number){
			return $number;
		}
		if(is_float($number)){
			return new FloatNumber($number);
		}
		if(is_int($number)){
			return new RationalNumber($number);
		}
		throw new \Excpetion($number." is not a correct number");
	}

	public function getMedian(){
		$n = $this->getN();
		if($n %2 == 1){
			$n = ($n+1)/2;
		}else{
			$n = $n/2;
		}
		return $this->get($n);
	}

	public function getRange():Number{ //Spannweite
		$n = $this->getN();
		return $this->get($n)->add($this->get(1)->negate());
	}

	public function getInterQuartileRange():Number{//Quartilabstand oder Interquartilabstand
		return $this->getPQuantil(0.75)->add($this->getPQuantil(0.25)->negate());
	}

	public function getPQuantil($p):Number{ //Auf Wikipedia anders definiert, als im Script!
		$np = $this->getN()*$p;
		if((int) $np != $np){
			$np = ((int) $np )+1;
		}
		return $this->get($np);
	}

	/*public function getSampleVariance(){

	}*/

	public function getEmpiricalVariance():Number{ //Empirische Varianz oder empirische Stichprobenvarianz, auf Wikipedia zusätzlich andere Definition!
		$sum = new RationalNumber(0);
		$arithmeticalAverage = $this->getArithmeticalAverage();
		foreach($this->getData() as $x){
			$p = $x->copy()->add($arithmeticalAverage->negate());
			$p = $p->mul($p);
			$sum= $sum->add($p);
		}
		$sum = $sum->mul(new RationalNumber(1, $this->getN()-1));
		return $sum;
	}

	public function getEmpirischeStreuung():Number{ //Empirische Streueung
		$eV = $this->getEmpiricalVariance()->evaluate();
		$eV = sqrt($eV);
		return new FloatNumber($eV);
	}

	public function getArithmeticalAverage():Number{
		$sum=new RationalNumber(0);
		foreach($this->getData() as $x){
			$sum = $sum->add($x);
		}
		$sum = $sum->mul(new RationalNumber(1, $this->getN()));
		return $sum;
	}

	public function getAlphaGestutztesMittel($alpha):Number{
		$n = $this->getN();
		$k = (int) $n*$alpha;
		$sum = new RationalNumber(0);
		for($i=$k+1;$i<=$n-$k;$i++){
			$sum = $sum->add($this->get($i));
		}
		return $sum->mul(new RationalNumber(1, $n - 2*$k));
	}
}