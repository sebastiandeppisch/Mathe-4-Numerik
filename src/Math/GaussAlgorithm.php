<?php
namespace Math;
class GaussAlgorithm{

	private $a;

	private $b;

	public function __construct(Matrix $a, Vector $b){
		$this->a=$a;
		$this->b=$b;
	}

	public function solve($iterations = null):GuassAlgorithmResult{
		
	}
}

// cond(V ) v
class GaussAlgorithmResult{
    private $l;
    private $r;
    private $c;

    public function __construct(Matrix $l, Matrix $r, Vector $c, Matrix $a, Matrix $b, Matrix $p, Matrix $q){
        $this->l=$l;
        $this->r=$r;
        $this->c=$c;
        $this->a=$a;
        $this->b=$b;
        $this->p=$p;
        $this->q=$q;
    }

    public function getL(){
        return $this->l;
    }

    public function getR(){
        return $this->r;
    }

    public function getC(){
        return $this->c;
    }

    public function getA(){
        return $this->a;
    }

    public function getB(){
        return $this->b;
    }

    public function getP(){
        return $this->p;
    }

    public function getQ(){
        return $this->q;
    }
}