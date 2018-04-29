<?php
namespace Math;
class MFunctionSet implements EvaluatableFloat{
	private $partialMFunctions;
	public function __construct(array $functions){
		$this->partialMFunction=$functions;
	}

	public function evaluate(float $value){
		foreach($this->partialMFunction as $part){
			if($part->inRange($value)){
				return $part->evaluate($value);
			}
		}
		return null;
	}
}