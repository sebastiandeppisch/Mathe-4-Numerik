<?php
namespace Math;

class RPolynomialSummand extends PolynomialSummand{
    public function __construct($number, $exponentiation=0, $variable="x"){
        if($number instanceof RationalNumber){
            $this->number=$number;
        }else{
            $this->number= new RationalNumber($number, 1);
        }
        $this->exponentiation=$exponentiation;
        $this->variable=$variable;
    }

    public function getRationalNumber(){
        return $this->number;
    }

    public function setRationalNumber(RationalNumber $number){
        $this->number=$number;
        return $this;
    }


    public function getVariable(){
        return $this->variable;
    }

    public function evaluate($value){
        if($value instanceof RationalNumber){
            $result = $this->number->copy();
            return $result->mul(new RationalNumber(pow($value->getP(), $this->exponentiation), pow($value->getP(), $this->exponentiation)));
        }else{
            return $this->number->evaluate()*pow($value, $this->exponentiation);
        }   
    }


    public function divNumber($number){
        $this->number->mul(new RationalNumber(1, $number));
        return $this;
    }

    public function copy(){
        return new RPolynomialSummand($this->getRationalNumber()->copy(), $this->getExponentiation(), $this->getVariable());
    }

    public function toString(){
        $rationalNumber = $this->getRationalNumber()->toString(true);
        if($this->exponentiation !== 1){
            $variableAndExponent=sprintf("%s^%s", $this->variable, $this->exponentiation);
        }else{
            $variableAndExponent=sprintf("%s", $this->variable);
        }
        
        if($this->exponentiation == 0 || $rationalNumber == "0"){
            return $rationalNumber;
        }
        if($rationalNumber == "1"){
            return $variableAndExponent;
        }
        if($rationalNumber == "-1"){
            return "-".$variableAndExponent;
        }  
        return $rationalNumber.$variableAndExponent;      
    }

    public function signed(){
        return $this->number->getP() < 0;
    }

    public function toFloat(){
        return new FPolynomialSummand($this->getNumber()->evaluate(), $this->getExponentiation(), $this->getVariable());
    }

}