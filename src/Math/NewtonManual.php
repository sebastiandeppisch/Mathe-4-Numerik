<?php
namespace Math;
class NewtonManual extends Newton{
	private $xNodes;

	private $yNodes;

	public function __construct(MFunction $func, array $xNodes, array $yNodes){
		parent::__construct($func, null, count($xNodes)-1, null);
		$this->xNodes=$xNodes;
		$this->yNodes=$yNodes;
		$this->degree=count($xNodes)-1;
	}
	public function getX($n){
		if(!is_numeric($n)){
			$n = $n->evaluate();
		}
		return $this->xNodes[$n]->evaluate();
	}

	public function getY($n){
		if(!is_numeric($n)){
			$n = $n->evaluate();
		}
		return $this->yNodes[$n]->evaluate();
	}
}