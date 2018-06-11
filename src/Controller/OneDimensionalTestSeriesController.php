<?php 
namespace Controller;
use Math\OneDimensionalTestSeries;
class OneDimensionalTestSeriesController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"array-rational",
			"name"=>"data",
			"description"=>"Werte",
			"default" => "1/2,2,3,5,7"
		]
	];
	
	private $testSeries;

	public function setData($parameters){
		parent::setData($parameters);
		$this->testSeries =	new OneDimensionalTestSeries($this->data["data"]);
	}

	public function getOutputHTML(){
		$html = $this->matrix->toHTML();
		return $html;
	}
}