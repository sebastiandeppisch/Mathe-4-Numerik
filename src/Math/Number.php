<?php
namespace Math;
abstract class Number{
	abstract public function reciprocal();

	abstract public function negate();

	public function toFloat():FloatNumber{
		if($this instanceof FloatNumber){
			return $this;
		}
		return new FloatNumber($this->evaluate());
	}

	static public function fromString($number):Number{
		if($number instanceof Number){
            return $number;
		}
		if(is_float($number)){
			return new FloatNumber($number);
		}
		if(strpos($number, ".") !== false){
            return FloatNumber::fromString($number);
        }
        if(is_string($number)){
            return RationalNumber::fromString($number);
        }
        if(is_int($number)){
            return new RationalNumber($number);
        }
        throw new \Exception($number." is not a correct number");
	}

	public function mul(Number $rhs):Number{
		if($this instanceof FloatNumber || $rhs instanceof FloatNumber){
			return $this->toFloat()->mulFloat($rhs->toFloat());
		}
		return $this->mulRational($rhs);
	}

	public function add(Number $rhs):Number{
		if($this instanceof FloatNumber || $rhs instanceof FloatNumber){
			return $this->toFloat()->addFloat($rhs->toFloat());
		}
		return $this->addRational($rhs);
	}
}