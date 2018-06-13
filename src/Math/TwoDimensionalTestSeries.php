<?php
namespace Math;
class TwoDimensionalTestSeries{
	private $x;
	private $y; 
	public function __construct(array $x, array $y){
		foreach($x as &$number){
			$number = $this->convertNumber($number);
		}

		foreach($y as &$number){
			$number = $this->convertNumber($number);
		}
		
		$this->x=$x;
		$this->y=$y;
	}

	public function getX(){
		return $this->y;
	}

	public function getY(){
		return $this->y;
	}

	public function getXi($i){
		return $this->x[$i-1];
	}

	public function getYi($i){
		return $this->y[$i-1];
	}


	public function getN(){
		return count($this->x);
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

	public function getArithmeticalAverageX():Number{
		$s = new OneDimensionalTestSeries($this->getX());
		return $s->getArithmeticalAverage();
	}

	public function getArithmeticalAverageY():Number{
		$s = new OneDimensionalTestSeries($this->getY());
		return $s->getArithmeticalAverage();
	}

	public function getEmpiricalVarianceX():Number{
		$s = new OneDimensionalTestSeries($this->getX());
		return $s->getEmpiricalVariance();
	}

	public function getEmpiricalVarianceY():Number{
		$s = new OneDimensionalTestSeries($this->getY());
		return $s->getEmpiricalVariance();
	}

	public function getEmpirischeStreuungX():Number{
		$s = new OneDimensionalTestSeries($this->getX());
		return $s->getEmpirischeStreuung();
	}

	public function getEmpirischeStreuungY():Number{
		$s = new OneDimensionalTestSeries($this->getY());
		return $s->getEmpirischeStreuung();
	}

	public function getEmpirischeKovarianz():Number{
		
	}

	public function getEmpirischerKorrelationskoeffizient():Number{
		
	}

}