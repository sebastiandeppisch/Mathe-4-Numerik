<?php
namespace Math;

class FPolynomialSummand extends PolynomialSummand{
    public function __construct($number, $exponentiation=0, $variable="x"){
        if($number instanceof FloatNumber){
            $this->number=$number;
        }else{
            $this->number= new FloatNumber($number);
        }
        $this->exponentiation=$exponentiation;
        $this->variable=$variable;
    }

    
    public function evaluate($value){
        $result = $this->getNumber()->copy();
        return $result->evaluate()*pow($value, $this->exponentiation);
    }

    public function divNumber($number):FPolynomialSummand{
        $this->number->setF($this->getNumber()->getF()/$number);
        return $this;
    }


    public function toString(){
        $number = $this->getNumber()->toString(true);
        if($this->exponentiation !== 1){
            $variableAndExponent=sprintf("%s^%s", $this->variable, $this->exponentiation);
        }else{
            $variableAndExponent=sprintf("%s", $this->variable);
        }
        
        if($this->exponentiation == 0 || $number == "0"){
            return $number;
        }
        if($number == "1"){
            return $variableAndExponent;
        }
        if($number == "-1"){
            return "-".$variableAndExponent;
        }  
        return $number.$variableAndExponent;      
    }

    public function signed(){
        return $this->getNumber()->signed();
    }

    public function toInnerHTML($signed=true){
        $number = $this->getNumber()->toHTML($signed);
        if($this->exponentiation !== 1){
            $variableAndExponent=sprintf("%s<sup>%s</sup>", $this->variable, $this->exponentiation);
        }else{
            $variableAndExponent=sprintf("%s", $this->variable);
        }
        
        if($this->exponentiation == 0 || $this->getNumber()->evaluate() == 0.0){
            return $number;
        }
        if($this->getNumber()->evaluate() == 1.0){
            return $variableAndExponent;
        }
        if($this->getNumber()->evaluate() == -1.0){
            return "-".$variableAndExponent;
        }  
        return $number.$variableAndExponent;
    }

    public function toHTML($signed=true){
        return '<div class="polynomialsummand">'.$this->toInnerHTML($signed).'</div>';
    }

    public function toFloat(){
        return $this->copy();
    }
}