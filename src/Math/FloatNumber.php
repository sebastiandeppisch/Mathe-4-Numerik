<?php
namespace Math;

use Exception\DivisionNullException;
class FloatNumber extends Number{
	private $f;
	public function __construct(float $f){
		$this->setF($f);
	}

	public function add(FloatNumber $rhs):FloatNumber{
		$this->setF($this->getF()+$rhs->getF());
		return $this;
	}

	public function mul(FloatNumber $rhs):FloatNumber{
		$this->setF($this->getF()*$rhs->getF());
		return $this;
	}

	public function setF($f){
		$this->f=(float) $f;
	}

	public function getF(){
		return $this->f;
	}

	public function toHTML($signed = true){
		$f =($signed)?$this->getF():abs($this->getF());
		return '<div class="floatnumber">'.$f.'</div>';
	}

	public function evaluate():float{
		return $this->getF();
	}

	public function toString(){
		$f = (string) $this->getF();
		if(strpos($f, ".") === false){
			$f.=".0";
		}
		return $f;
	}

	public function copy(){
		return new FloatNumber($this->getF());
	}

	public function signed(){
		return $this->getF() < 0;
	}

	public function reciprocal(){
		return new FloatNumber(1/$this->getF());
	}

	public function negate(){
		return new FloatNumber(-1*$this->getF());
	}
}