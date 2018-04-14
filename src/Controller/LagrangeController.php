<?php 
namespace Controller;
class LagrangeController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"function",
			"name"=>"function",
			"description"=>"Zu interpolierende Funktion"
		],
		[
			"type"=>"int",
			"name"=>"a",
			"description"=>"Von"
		],
		[
			"type"=>"int",
			"name"=>"b",
			"description"=>"Bis"
		],
		[
			"type"=>"int",
			"name"=>"degree",
			"description"=>"Grad"
		]
	];
	
	private $lagrange;
	public function __constructor(){
		$this->lagrange = new \Math\Lagrange($this->data["function"], $this->data["degree"], $this->data["a"], $this->data["b"]);
	}

	public function getX(){
		//return
	}

	public function getLagrangePolynomials(){
		return $this->lagrange->getLagrangePolynomials();
	}

	public function getOutputHTML(){
		/*$this->getLagrangePolynomials();
		if(isset($this->data["function"]) && $this->data["function"] !== NULL){
			return $this->data["function"]->evaluate($this->data["a"]);
		}*/
		$test = new \Math\RationalNumber(14234234, 56546);
		return $test->toHTML();
	}
}