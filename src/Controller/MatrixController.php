<?php 
namespace Controller;

use Math\Matrix;

class MatrixController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"matrix",
			"name"=>"matrix",
			"description"=>"Matrix",
			"default" => [[0,1,2],[3,4,5],[6,7,8]],
		]
	];

	private $matrix;

	public function setData($parameters){
		parent::setData($parameters);
		$this->matrix =	$this->data["matrix"];
	}

	public function getOutputHTML(){
		$html = $this->matrix->toHTML();
		return $html;
	}
}