<?php 
namespace Controller;
use Math\OneDimensionalTestSeries;
class OneDimensionalTestSeriesController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"array",
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
		$html = '<table class="table"><thead><tr><th>Wert</th><th>Formelzeichen</th><th>Rational</th><th>Reell</th></tr></thead><tbody>';
		$html.=sprintf("<tr><td>Arithmetisches Mittel</td><td>x̄</td><td>%s</td><td>%s</td></tr>", $s->getArithmeticalAverage()->toHTML(), $s->getArithmeticalAverage()->toFloat()->toHTML());
		$html.=sprintf("<tr><td>Median</td><td>x̃</td><td>%s</td><td>%s</td></tr>", $s->getMedian()->toHTML(), $s->getMedian()->toFloat()->toHTML());
		$html.=sprintf("<tr><td>0.25 Quantil</td><td>x<sub>0.25</sub></td><td>%s</td><td>%s</td></tr>", $s->getPQuantil(0.25)->toHTML(), $s->getPQuantil(0.35)->toFloat()->toHTML());
		$html.=sprintf("<tr><td>0.72 Quantil</td><td>x<sub>0.75</sub></td><td>%s</td><td>%s</td></tr>", $s->getPQuantil(0.75)->toHTML(), $s->getMedian(0.75)->toFloat()->toHTML());
		$html.=sprintf("<tr><td>0.1 gestutztes Mittel</td><td></td><td>%s</td><td>%s</td></tr>", $s->getAlphaGestutztesMittel(0.1)->toHTML(), $s->getAlphaGestutztesMittel(0.1)->toFloat()->toHTML());
		$html.=sprintf("<tr><td>Empirische Varianz</td><td>s<sup>2</sup></td><td>%s</td><td>%s</td></tr>", $s->getEmpiricalVariance()->toHTML(), $s->getEmpiricalVariance()->toFloat()->toHTML());
		$html.=sprintf("<tr><td>Empirische Streuung</td><td>s</td><td>...</td><td>%s</td></tr>", $s->getEmpirischeStreuung()->toHTML());
		$html.=sprintf("<tr><td>Spanweite</td><td>v</td><td>%s</td><td>%s</td></tr>", $s->getRange()->toHTML(), $s->getRange()->toFloat()->toHTML());
		$html.=sprintf("<tr><td>Quartilabstand</td></td><td>q</td><td>%s</td><td>%s</td></tr>", $s->getInterQuartileRange()->toHTML(), $s->getInterQuartileRange()->toFloat()->toHTML());
		$html.='</tbody></table>';
		return $html;
	}
}