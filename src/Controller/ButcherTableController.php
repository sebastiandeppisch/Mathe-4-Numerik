<?php 
namespace Controller;

use Math\Matrix;
use Math\ButcherTable;

class ButcherTableController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"matrix",
			"name"=>"table",
			"description"=>"table",
			"default" => [[0, 0, 0, 0, 0],
			["1/2", "1/2", 0, 0, 0],
			["1/2", 0, "1/2", 0, 0],
			[1, 0, 0, 1, 0],
			[0, "1/6", "1/3", "1/3", "1/6"]],
		]
	];

	private $butcherTable;

	public function setData($parameters){
		parent::setData($parameters);
		$this->butcherTable = ButcherTable::fromArray($this->data["table"]->getArray());
	}

	public function getOutputHTML(){
		$html = $this->butcherTable->toHTML();
		return $html;
	}
}

