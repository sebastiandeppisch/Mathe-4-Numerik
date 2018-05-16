<?php 
namespace Controller;
class PolynomExampleController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"polynom",
			"name"=>"polynom",
			"description"=>"Polynom",
			"default"=> "3x^4+12x^1+5"
		],
		[
			"type"=>"number",
			"name"=>"div",
			"description"=>"Teilen durch",
			"default" => "4"
		]
	];

	public function getOutputHTML(){
		if(isset ($this->data["polynom"]) && $this->data["polynom"]!==NULL){
			$div = $this->data["div"];
			if($div == ""){
				$div=1;
			}
			return $this->data["polynom"]->divNumber($div)->toHTML();
		}
		return "No Polynom given";
	}
}