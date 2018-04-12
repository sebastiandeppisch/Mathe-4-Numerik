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
		return $this->data["polynom"]->toHTML();
	}
}