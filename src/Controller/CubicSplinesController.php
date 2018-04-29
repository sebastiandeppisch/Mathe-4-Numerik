<?php 
namespace Controller;

use Math\NaturalCubicSplines;
use Math\MFunction;
use Math\PartialMFunction;

class CubicSplinesController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"array-rational",
			"name"=>"xnodes",
			"description"=>"X-Werte",
			"default" => "0,1,2,3",
		],
		[
			"type"=>"array-rational",
			"name"=>"ynodes",
			"description"=>"Y-Werte",
			"default" => "1,2,1,4",
		]
	];

	private $splines;

	public function setData($parameters){
		parent::setData($parameters);
		$this->splines = new NaturalCubicSplines($this->data["xnodes"], $this->data["ynodes"]);
		//$this->splines = new NaturalCubicSplines([0, 1,2], [1,2,1]);
	}

	public function getSplines(){
		return $this->splines;
	}

	public function getOutputHTML(){
		$splines = $this->getSplines();
		$les = $splines->getSystemOfLinearEquation();
		$html = $les->toHTML();
		$html.="<table class='table'><thead><tr><th>M</th><th>D</th><th>C</th><th>S</th></tr></thead><body>";
		for($i=0;$i<=$splines->getDegree();$i++){
			$html.="<tr>";
			$html.="<td>M<sub>".$i."</sub>=".$splines->getM($i)->toHTML()."</td>";
			if($i<$splines->getDegree()){
				$html.="<td>D<sub>".$i."</sub>=".$splines->getD($i)->toHTML()."</td>";
				$html.="<td>C<sub>".$i."</sub>=".$splines->getC($i)->toHTML()."</td>";
				$html.="<td>S<sub>".$i."</sub>(x)=".$splines->getS($i)->toHTML()."</td>";
			}
			$html.="</tr>";
		}
		$html.="</body></table>";
		return $html;
	}

	public function getChart(){
		$charts=[];
		$splines = $this->getSplines();
		$chart = new ChartController("Kubische Splines");
		$chartS = new ChartConTroller("S-Komplett");
		$parts=[];
		for($i=0;$i<$splines->getDegree();$i++){
			$from = $splines->getX($i)->evaluate();
			$to = $splines->getX($i+1)->evaluate();
			$spline = $splines->getS($i)->toString();
			$parts[]=new PartialMFunction(new MFunction($spline), $from, $to);
			$chartS->addChart(new MFunction($this->getSplines()->getS($i)->toString()), "s_".$i);
		}
		$chart->addChart(new \Math\MFunctionSet($parts), "s(x)");
		
		$chart->setFrom($this->data["xnodes"][0]->evaluate())
			->setTo(end($this->data["xnodes"])->evaluate());
		$chartS->setFrom($this->data["xnodes"][0]->evaluate())
		->setTo(end($this->data["xnodes"])->evaluate());

		$charts[]=$chart;
		$charts[]=$chartS;
		return $charts;
	}
}