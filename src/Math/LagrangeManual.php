<?php
namespace Math;
class LagrangeManual extends Lagrange{
	private $nodes;

	public function __construct(MFunction $func, array $nodes){
		parent::__construct($func, null, count($nodes)-1, null);
		$this->nodes=$nodes;
		$this->degree=count($nodes)-1;
	}
	public function getX($n){
		return $this->nodes[$n]->copy();
	}
}