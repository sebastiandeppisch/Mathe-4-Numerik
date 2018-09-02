<?php
namespace Math;
abstract class Number{
	abstract public function reciprocal();

	abstract public function negate();

	public function toFloat():FloatNumber{
		return new FloatNumber($this->evaluate());
	}

	abstract public function copy();

	public function __clone(){
		return $this->copy();
	}
}