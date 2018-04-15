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

	public function setData($parameters){
		parent::setData($parameters);
		$this->lagrange = new \Math\Lagrange($this->data["function"], $this->data["degree"], $this->data["a"], $this->data["b"]);
	}

	public function getX(){
		//return
	}

	public function getLagrangePolynomials(){
		return $this->lagrange->getPolynomials();
	}

	public function getOutputHTML(){
		var_dump($this->lagrange);
		$this->getLagrangePolynomials();
		if(isset($this->data["function"]) && $this->data["function"] !== NULL){
			$html="";
			foreach($this->getLagrangePolynomials() as $p){
				$html.="<div>".$p->toHTML()."</div>";
			}
			return $html;
		}
		
	}
}