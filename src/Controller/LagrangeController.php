<?php 
namespace Controller;
use Math\MFunction;
class LagrangeController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"function",
			"name"=>"function",
			"description"=>"Zu interpolierende Funktion",
			"default" => "sin(x)"
		],
		[
			"type"=>"select",
			"name"=>"type",
			"description"=>"Stützstellen",
			"default" => "linear",
			"values"=>[
				"linear" => "Linear",
				"manual" => "Selbst eingeben",
				"chebyshev" => "Tschebyschevabszissen"
			]
		],
		[
			"type"=>"int",
			"name"=>"a",
			"description"=>"Von",
			"default" => "0",
			"show" => [
				[
					"name" => "type",
					"value" => "chebyshev"
				],
				[
					"name" => "type",
					"value" => "linear"
				]
			]
		],
		[
			"type"=>"int",
			"name"=>"b",
			"description"=>"Bis",
			"default" => "3",
			"show" => [
				[
					"name" => "type",
					"value" => "chebyshev"
				],
				[
					"name" => "type",
					"value" => "linear"
				]
			]
		],
		[
			"type"=>"int",
			"name"=>"degree",
			"description"=>"Grad",
			"default" => "3",
			"show" => [
				[
					"name" => "type",
					"value" => "chebyshev"
				],
				[
					"name" => "type",
					"value" => "linear"
				]
			]
		],
		[
			"type"=>"array",
			"name"=>"nodes",
			"description"=>"Stützstellen angeben",
			"default" => "0,1/2,1",
			"show" => [
				[
					"name" => "type",
					"value" => "manual"
				]
			]
		]
	];
	
	private $lagrange;

	public function setData($parameters){
		parent::setData($parameters);
		switch($this->data["type"]){
			case "linear":
				$this->lagrange = new \Math\LagrangeLinear($this->data["function"], $this->data["degree"], $this->data["a"], $this->data["b"]);
			break;
			case "chebyshev":
				$this->lagrange = new \Math\LagrangeChebyshev($this->data["function"], $this->data["degree"], $this->data["a"], $this->data["b"]);
			break;
			case "manual":
				$this->lagrange = new \Math\LagrangeManual($this->data["function"], $this->data["nodes"]);
			break;
		}
	}

	public function getX(){
		//return
	}

	public function getLagrangePolynomials(){
		return $this->lagrange->getPolynomials();
	}

	public function getResult(){
		static $result = null;
		if($result === null){
			$result = $this->lagrange->getResult();
		}
		return $result;
	}

	public function getOutputHTML(){
		$this->getLagrangePolynomials();
		if(isset($this->data["function"]) && $this->data["function"] !== NULL){
			$html="";
			$i=0;
			$pols = $this->getLagrangePolynomials();
			$n = count($pols);
			foreach($pols as $p){
				$html.="<div class='result-outer'><div class='result-lhs'>L<sub>$i,$n</sub>=</div>".$p->toHTML()."</div>";
				$i++;
			}
			$html.="<hr>";
			$html.="<div class='result-outer'><div class='result-lhs'>p(x<sub>i</sub>)=</div>".$this->getResult()->toHTML()."</div>";
			$html.="<div class='result-outer'><div class='result-lhs'>p(x<sub>i</sub>)=</div>".$this->getResult()->toString()."</div>";

			return $html;
		}
		
	}

	public function getChart(){
		$chart = new ChartController();
		$chart->addChart(new MFunction($this->getResult()->toString()), "Interpolation")
			->addChart($this->data["function"], "Funktion")
			->setFrom($this->data["a"])
			->setTo($this->data["b"]);
		return $chart;
	}
}