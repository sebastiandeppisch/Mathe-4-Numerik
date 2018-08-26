<?php
namespace Math\Algorithms;

use Math\Matrix;
use Math\Number;
use Math\RationalNumber;
use Math\FloatNumber;
class CholeskyDecomposition{
    private $matrix;
    public function __construct(Matrix $a){
        $this->matrix = $a;
    }

    public function getL(int $i, int $j):Number{
        if($j > $i){
            return new RationalNumber(0);
        }
        if($i === $j){
            $number = $this->matrix->get($j-1, $j-1)->copy();
            $sum = new RationalNumber(0);
            for($k=1;$k<=$j-1;$k++){
                $l = $this->getL($j, $k);
                $l = $l->mul($l);
                $sum = $sum->add($l);
            }
            $number = $number->add($sum->negate());
            if($number->evaluate() <= 0){
                throw new \Exception("Matrix ist nicht definit, Fehler aufgetreten in: l<sub>".$i.",".$j."</sub>");
            }
            return new FloatNumber(sqrt($number->evaluate()));
        }else{
            $number = $this->matrix->get($i-1, $j-1)->copy();
            $sum = new RationalNumber(0);
            for($k=1;$k<=$j-1;$k++){
                $l = $this->getL($i, $k);
                $l = $l->mul($this->getL($j, $k));
                $sum = $sum->add($l);
            }
            $number = $number->add($sum->negate());
            return $number->mul($this->getL($j, $j)->reciprocal());
        }
    }

    public function getLMatrix():Matrix{
        $rows = $this->matrix->getNRows();
        $cols = $this->matrix->getNCols();
        $l = new Matrix($rows, $cols);
        for($i=1;$i<=$rows;$i++){
            for($j=1;$j<=$cols;$j++){
                $l->set($i-1, $j-1, $this->getL($i, $j));
            }
        }
        return $l;
    }
}