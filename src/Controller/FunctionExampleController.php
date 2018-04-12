<?php 
namespace Controller;
class FunctionExampleController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"function",
			"name"=>"function",
			"description"=>"Funktion"
		],
		[
			"type"=>"int",
			"name"=>"number",
			"description"=>"Auswerten an"
		]
	];

	public function getOutputHTML(){
		return $this->data["function"]->evaluate($this->data["number"]);
	}
}