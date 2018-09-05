<?php 
namespace Controller;
use Math\MFunction;

use Math\ClosedNewtonCotesQuadrature;
class NewtonCotesQuadraturController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"select",
			"name"=>"type",
			"description"=>"Geschlossen / Offen",
			"default" => "closed",
			"values"=>[
				"closed" => "Geschlossene Newton-Cotes-Quadratur",
				"open" => "Offene Newton-Cotes-Quadratur"
			]
		],
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
			"type"=>"array",
			"name"=>"ynodes",
			"description"=>"Y-Werte",
			"default" => "1,2,3",
			"show" => [
				[
					"name" => "ytype",
					"value" => "manual"
				]
			]
		],
		[
			"type"=>"function",
			"name"=>"function",
			"description"=>"Zu integrierende Funktion",
			"default" => "exp(x^2)",
			"show" => [
				[
					"name" => "ytype",
					"value" => "function"
				]
			]
		],
		[
			"type"=>"int",
			"name"=>"a",
			"description"=>"a",
			"default" => "0"
		],
		[
			"type"=>"int",
			"name"=>"b",
			"description"=>"b",
			"default" => "3"
		],
		[
			"type"=>"int",
			"name"=>"n",
			"description"=>"N",
			"default" => "2",
			"show" => [
				[
					"name" => "ytype",
					"value" => "function"
				]
			]
		]
	];
	
	private $newton;

	public function setData($parameters){
		parent::setData($parameters);
		if($this->data["type"] !="closed"){
			throw new \Exception("TODO, noch nicht implementiert");
		}else{
			if($this->data["ytype"] == "manual"){
				$this->newton = new ClosedNewtonCotesQuadrature($this->data["a"], $this->data["b"], $this->data["ynodes"]);
			}else{
				$this->newton = ClosedNewtonCotesQuadrature::fromFunc($this->data["a"], $this->data["b"], $this->data["n"], $this->data["function"]);
			}
		}
	}


	public function getOutputHTML(){
		$i = $this->newton->getI();
		return "I<sub>".$this->newton->getN()."</sub>=".$i->toHTML()."=".$i->toFloat()->toHTML();		
	}
}