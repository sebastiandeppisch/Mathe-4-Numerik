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
		$s = $this->testSeries;
		$html = "<ul>";
		$html.=sprintf("<li>Arithmetisches Mittel: %s Float: %f</li>", $s->getArithmeticalAverage()->toHTML(), $s->getArithmeticalAverage()->evaluate());
		$html.=sprintf("<li>Median: %s Float: %f</li>", $s->getMedian()->toHTML(), $s->getMedian()->evaluate());
		$html.=sprintf("<li>0.25 Quantil: %s Float: %f</li>", $s->getPQuantil(0.25)->toHTML(), $s->getPQuantil(0.35)->evaluate());
		$html.=sprintf("<li>0.72 Quantil: %s Float: %f</li>", $s->getPQuantil(0.75)->toHTML(), $s->getMedian(0.75)->evaluate());
		$html.=sprintf("<li>0.1 gestutztes Mittel: %s Float: %f</li>", $s->getAlphaGestutztesMittel(0.1)->toHTML(), $s->getAlphaGestutztesMittel(0.1)->evaluate());
		$html.=sprintf("<li>Empirische Varianz %s Float: %f</li>", $s->getEmpiricalVariance()->toHTML(), $s->getEmpiricalVariance()->evaluate());
		$html.=sprintf("<li>Empirische Streuung: %s </li>", $s->getEmpirischeStreuung()->toHTML());
		$html.=sprintf("<li>Spanweite %s Float: %f</li>", $s->getRange()->toHTML(), $s->getRange()->evaluate());
		$html.=sprintf("<li>Quartilabstand %s Float: %f</li>", $s->getInterQuartileRange()->toHTML(), $s->getInterQuartileRange()->evaluate());
		$html.="</ul>";
		return $html;
	}
}