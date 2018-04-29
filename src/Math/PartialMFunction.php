<?php
namespace Math;
class PartialMFunction{
	private $mFunction;
	private $from;
	private $to;
	public function __construct(MFunction $func, float $from, float $to){
		$this->mFunction=$func;
		$this->from=$from;
		$this->to=$to;
	}

	public function evaluate(float $value):float{
		return $this->mFunction->evaluate($value);
	}

	public function toString(){
		return $mFunction->toString();
	}

	public function inRange(float $value){
		if($value >= $this->from){
			if($value <= $this->to){
				return true;
			}
		} 
		return false;
	}
}