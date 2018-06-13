<?php 
namespace Controller;
use Math\OneDimensionalTestSeries;
class TwoDimensionalTestSeriesController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"array-rational",
			"name"=>"data-x",
			"description"=>"Werte",
			"default" => "1,2,3,4,5"
		],
		[
			"type"=>"array-rational",
			"name"=>"data-y",
			"description"=>"Werte",
			"default" => "1/2,2,3,5,7"
		]
	];
	
	private $testSeries;

	public function setData($parameters){
		parent::setData($parameters);
		$this->testSeries =	new OneDimensionalTestSeries($this->data["data-x"], $this->data["data-y"]);
	}

	public function getOutputHTML(){
		$s = $this->testSeries;
		$html = "<ul>";
		$html.=sprintf("<li>Arithmetisches Mittel x : %s Float: %f</li>", $s->getArithmeticalAverageX()->toHTML(), $s->getArithmeticalAverageX()->evaluate());
		$html.=sprintf("<li>Arithmetisches Mittel y : %s Float: %f</li>", $s->getArithmeticalAverageY()->toHTML(), $s->getArithmeticalAverageY()->evaluate());

		$html.=sprintf("<li>Empirische Varianz X %s Float: %f</li>", $s->getEmpiricalVarianceX()->toHTML(), $s->getEmpiricalVarianceX()->evaluate());
		$html.=sprintf("<li>Empirische Varianz Y %s Float: %f</li>", $s->getEmpiricalVarianceY()->toHTML(), $s->getEmpiricalVarianceY()->evaluate());

		$html.=sprintf("<li>Empirische Streuung X: %s </li>", $s->getEmpirischeStreuungX()->toHTML());
		$html.=sprintf("<li>Empirische Streuung Y: %s </li>", $s->getEmpirischeStreuungY()->toHTML());

		$html.=sprintf("<li>Empirische Kovarianz s_xy: %s </li>", $s->getEmpirischeKovarianz()->toHTML());

		$html.=sprintf("<li>Empirischer Korrelationskoeffizient: %s </li>", $s->getEmpirischerKorrelationskoeffizient()->toHTML());
		$html.="</ul>";
		return $html;
	}
}