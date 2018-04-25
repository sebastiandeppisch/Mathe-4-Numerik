<?php 
namespace Controller;

use Math\NaturalCubicSplines;
class CubicSplinesController extends Controller{
	static protected $inputFields=[
	];

	public function getOutputHTML(){
		$test = new NaturalCubicSplines([0,1,2,3,4], [7,2,4,5,-3]);
		$les = $test->getSystemOfLinearEquation();
		return $les->toHTML();
	}
}