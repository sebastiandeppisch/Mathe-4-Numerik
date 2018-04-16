<?php
namespace Math;
class NewtonLinear extends Newton{
	public function getX($n){
		$r = new RationalNumber($this->b-$this->a, $this->degree);
		$n = new RationalNumber($n, 1);
		$a = new RationalNumber($this->a, 1);
		$test = $r->mul($n)->add($a);
		return $test->evaluate();
	}
}