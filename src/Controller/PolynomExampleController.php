<?php 
namespace Controller;
class PolynomExampleController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"polynom",
			"name"=>"polynom",
			"description"=>"Polynom"
		]
	];

	public function getOutputHTML(){
		if(isset ($this->data["polynom"]) && $this->data["polynom"]!==NULL){
			return $this->data["polynom"]->toHTML();
		}
		return "No Polynom given";
	}
}