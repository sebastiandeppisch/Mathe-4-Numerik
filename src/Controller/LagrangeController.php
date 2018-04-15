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

	public function getResult(){
		return $this->lagrange->getResult();
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
}