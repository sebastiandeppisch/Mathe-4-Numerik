<?php 
namespace Controller;

use Math\NaturalCubicSplines;
use Math\HermiteCubicSplines;
use Math\RationalNumber;
use Math\MFunction;
use Math\PartialMFunction;

class CubicSplinesController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"array",
			"name"=>"xnodes",
			"description"=>"X-Werte",
			"default" => "0,1,2,3",
		],
		[
			"type"=>"array",
			"name"=>"ynodes",
			"description"=>"Y-Werte",
			"default" => "1,2,1,4",
		],
		[
			"type"=>"select",
			"name"=>"type",
			"description"=>"Randbedingungen",
			"default" => "natural",
			"values"=>[
				"natural" => "Natürliche Randbedingungen",
				"hermite" => "Hermitsche Randbedingungen"
			]
		],
		[
			"type"=>"int",
			"name"=>"derivativeA",
			"description"=>"f'(a)",
			"default" => "0",
			"show" => [
				[
					"name" => "type",
					"value" => "hermite"
				]
			]
		],
		[
			"type"=>"int",
			"name"=>"derivativeB",
			"description"=>"f'(b)",
			"default" => "0",
			"show" => [
				[
					"name" => "type",
					"value" => "hermite"
				]
			]
		],
	];

	private $splines;

	public function setData($parameters){
		parent::setData($parameters);
		if($this->data["type"]=="hermite"){
			$this->splines = new HermiteCubicSplines($this->data["xnodes"], $this->data["ynodes"], new RationalNumber($this->data["derivativeA"]), new RationalNumber($this->data["derivativeB"]));
		}else{
			$this->splines = new NaturalCubicSplines($this->data["xnodes"], $this->data["ynodes"]);
		}
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
		$chartD = new ChartController("Kubische Splines 1-fache Ableitung");
		$chartDD = new ChartController("Kubische Splines 2-fache Ableitung");
		$parts=[];
		$partsD=[];
		$partsDD=[];
		for($i=0;$i<$splines->getDegree();$i++){
			$from = $splines->getX($i)->evaluate();
			$to = $splines->getX($i+1)->evaluate();
			$spline = $splines->getS($i)->toString();
			$splineD= $splines->getS($i)->derivate()->toString();
			$splineDD= $splines->getS($i)->derivate()->derivate()->toString();
			$parts[]=new PartialMFunction(new MFunction($spline), $from, $to);
			$partsD[]=new PartialMFunction(new MFunction($splineD), $from, $to);
			$partsDD[]=new PartialMFunction(new MFunction($splineDD), $from, $to);
			$chartS->addChart(new MFunction($this->getSplines()->getS($i)->toString()), "s_".$i);
		}
		$chart->addChart(new \Math\MFunctionSet($parts), "s(x)");
		$chartD->addChart(new \Math\MFunctionSet($partsD), "s'(x)");
		$chartDD->addChart(new \Math\MFunctionSet($partsDD), "s''(x)");
		
		$charts[]=$chart;
		$charts[]=$chartS;
		$charts[]=$chartD;
		$charts[]=$chartDD;
		foreach($charts as &$c){
			$c->setFrom($this->data["xnodes"][0]->evaluate())
			->setTo(end($this->data["xnodes"])->evaluate());
		}
		return $charts;
	}
}