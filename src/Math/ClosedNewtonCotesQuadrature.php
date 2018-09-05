<?php
namespace Math;
use Math\Exception\WrongArgumentException;
class ClosedNewtonCotesQuadrature extends NewtonCotesQuadrature{

    public function __construct($a, $b, array $y){
        parent::__construct($a, $b, $y);
        if($this->getN() > 4){
            throw new WrongArgumentException("Nur bis n=4 erlaubt");
        }
    }

    protected $alphas=[
        ["1/2", "1/2"],
        ["1/3", "4/3", "1/3"],
        ["3/8", "9/8", "9/8", "3/8"],
        ["14/45", "64/45", "24/45", "64/45", "14/45"]
    ];

    public function getX(int $i):Number{
        return $this->getA()->copy()->add($this->getH()->copy()->mul(new RationalNumber($i)));
    }

    public function getH():Number{
        $n = new RationalNumber($this->getN());
        return $this->getB()->copy()->add($this->getA()->negate())->mul($n->reciprocal());
    }

    public function getI(){
        $sum = new RationalNumber(0);
        for($i=0;$i<=$this->getN();$i++){
            $alpha = $this->getAlpha($i);
            $y=$this->getY($i);
            $alpha = $alpha->mul($y);
            $sum = $sum->add($alpha);
        }
        return $sum->mul($this->getH());
    }
}