<?php
namespace Math;
class PolynomialSummand implements EvaluatableInt{
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

    public function evaluate(int $value):int {
        return $this->number*pow($value, $this->exponentiation);
    }

    public function mul(PolynomialSummand $rhs):PolynomialSummand{
        if($rhs->getVariable() !== $this->getVariable()){
            throw new Exception\PolynomialSummand\WrongVariable();
        }
        $this->number*=$rhs->getNumber();
        $this->exponentiation*=$rhs->getExponentiation();
        return $this;
    }

    public function copy(){
        return new PolynomialSummand($this->getNumber(), $this->getExponentiation(), $this->getVariable());
    }
}