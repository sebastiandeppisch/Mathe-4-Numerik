<?php 
namespace Controller;
use Math\MFunction;
class NewtonController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"select",
			"name"=>"ytype",
			"description"=>"Y-Werte",
			"default" => "linear",
			"values"=>[
				"function" => "Funktion",
				"manual" => "Selbst eingeben"
			]
		],
		[
			"type"=>"function",
			"name"=>"function",
			"description"=>"Zu interpolierende Funktion",
			"default" => "sin(x)",
			"show" => [
				[
					"name" => "ytype",
					"value" => "function"
				]
			]
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
			"name"=>"xnodes",
			"description"=>"Stützstellen angeben",
			"default" => "0,1/2,1",
			"show" => [
				[
					"name" => "type",
					"value" => "manual"
				]
			]
		],
		[
			"type"=>"array",
			"name"=>"ynodes",
			"description"=>"Y-Wertangeben",
			"default" => "1,2,3",
			"show" => [
				[
					"name" => "ytype",
					"value" => "manual"
				]
			]
		]
	];
	
	private $newton;

	public function setData($parameters){
		parent::setData($parameters);
		switch($this->data["type"]){
			case "linear":
				$this->newton = new \Math\NewtonLinear($this->data["function"], $this->data["degree"], $this->data["a"], $this->data["b"]);
			break;
			case "chebyshev":
				$this->newton = new \Math\NewtonChebyshev($this->data["function"], $this->data["degree"], $this->data["a"], $this->data["b"]);
			break;
			case "manual":
				$this->newton = new \Math\NewtonManual($this->data["function"], $this->data["xnodes"], $this->data["ynodes"]);
			break;
		}
	}

	public function getX(){
		//return
	}

	/*public function getLagrangePolynomials(){
		return $this->lagrange->getPolynomials();
	}*/

	public function getResult(){
		static $result = null;
		if($result === null){
			$result = $this->newton->getResult();
		}
		return $result;
	}

	public function getFHTML(){
		$rows = $this->newton->getDegree()*2+1;
		$cols = $this->newton->getDegree()+2;
		$html="<table>";
		for($i=0;$i<$rows;$i++){
			$html.="<tr>";
			if($i%2 == 0){
				$html.="<td>x<sub>".($i/2)."</sub>=".$this->newton->getX($i/2)."</td>";
			}else{
				$html.="<td></td>";
			}
			$html.='<td style="width:1px;background-color:black;"></td>';
			for($j=1;$j<$cols;$j++){
				$html.='<td style="min-width:50px;padding:5px;">';
				$offset=$j-1;
				if(($j+$i) %2 == 1 && $i+1 >= $j && ($rows-$i) >= $j){
					$a = ((int)($i/2))-((int)(($j+1)/2))+1;
					$b = ((($j-1)+$i)/2);
					$range =array_map(function($i){
						return "x<sub>".$i."</sub>";
					}, range($a, $b));
					$html.="f<sub>[".implode(",",$range)."]</sub>=";
					$html.=$this->newton->getF($a, $b);
				}
				$html.="</td>";
			}
			$html.="</tr>";
		}
		$html.="</table>";
		return $html;
	}

	public function getOutputHTML(){
		//$this->getLagrangePolynomials();
		if(isset($this->data["function"]) && $this->data["function"] !== NULL){
			$html="";
			$i=0;
			$html.=$this->getFHTML();
			$html.="<hr>";
			$html.="<div class='result-outer'><div class='result-lhs'>p(x<sub>i</sub>)=</div>".$this->getResult()->toHTML()."</div>";
			$html.="<div class='result-outer'><div class='result-lhs'>p(x<sub>i</sub>)=</div>".$this->getResult()->toString()."</div>";

			return $html;
		}
		
	}

	public function getChart(){
		$chart = new ChartController();
		$chart->addChart(new MFunction($this->getResult()->toString()), "Interpolation");
		//if($this->data["ytype"] != "manual"){
			$chart->addChart($this->data["function"], "Funktion");
		//}	
		
		$chart->setFrom($this->data["a"])
			->setTo($this->data["b"]);
		return $chart;
	}
}