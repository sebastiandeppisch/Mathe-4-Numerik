<?php 
namespace Controller;
class FunctionExampleController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"function",
			"name"=>"function",
			"description"=>"Funktion",
			"default" => "x^2"
		],
		[
			"type"=>"int",
			"name"=>"number",
			"description"=>"Auswerten an",
			"default" => "2"
		]
	];

	public function getOutputHTML(){
		if(isset($this->data["function"])){
			return $this->data["function"]->evaluate($this->data["number"]);
		}
		
	}
}