<?php
namespace Math;
class PolynomialSummand{
    private $variable;

    private $exponentiation;
    private $number;

    public function __construct($number, $exponentiation=0, $variable="x"){
        $this->number =$number;
        $this->exponentiation=$exponentiation;
        $this->variable=$variable;
    }

    public function add(PolynomialSummand $rhs){
        if($rhs->getVariable() !== $this->getVariable()){
            throw new Exception\PolynomialSummand\WrongVariable();
        }
        if($rhs->getExponentiation() !== $this->getExponentiation()){
            throw new Exception\PolynomialSummand\WrongExponentiation();
        }
        $this->number+=$rhs->getNumber();
    }

    public function getExponentiation(){
        return $this->exponentiation;
    }

    public function getNumber(){
        return $this->number;
    }

    public function getVariable(){
        return $this->variable;
    }
}