<?php 
namespace Controller;

use Math\Matrix;
use Math\Algorithms\CholeskyDecomposition;

class CholeskyDecompositionController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"matrix",
			"name"=>"matrix",
			"description"=>"matrix",
			"default" => [[1, 2, 1],
            [2, 5, 4],
            [1, 4, 14]],
		]
	];

	private $cholesky;

	public function setData($parameters){
		parent::setData($parameters);
		$this->cholesky = new CholeskyDecomposition($this->data['matrix']);
	}

	public function getOutputHTML(){
		$html = $this->cholesky->getLMatrix()->toHTML();
		return $html;
	}
}

