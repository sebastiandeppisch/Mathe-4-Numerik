<?php
namespace Math;

class PolynomialSummand{
    private $variable;

    private $exponentiation;
    private $rationalNumber;

    public function __construct($number, $exponentiation=0, $variable="x"){
        if($number instanceof RationalNumber){
            $this->rationalNumber=$number;
        }else{
            $this->rationalNumber= new RationalNumber($number, 1);
        }
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
        $this->rationalNumber->add($rhs->getRationalNumber());
    }

    public function getExponentiation(){
        return $this->exponentiation;
    }

    public function getRationalNumber(){
        return $this->rationalNumber;
    }

    public function getNumber(){
        if($this->getRationalNumber()->getQ()=== 1){
            return $this->rationalNumber->getP();
        }
    }

    public function getVariable(){
        return $this->variable;
    }

    public function evaluate($value){
        if($value instanceof RationalNumber){
            $result = $this->rationalNumber->copy();
            return $result->mul(new RationalNumber(pow($value->getP(), $this->exponentiation), pow($value->getP(), $this->exponentiation)));
        }else{
            return $this->rationalNumber->evaluate()*pow($value, $this->exponentiation);
        }   
    }

    public function mul(PolynomialSummand $rhs):PolynomialSummand{
        if($rhs->getVariable() !== $this->getVariable()){
            throw new Exception\PolynomialSummand\WrongVariable();
        }
        $this->rationalNumber->mul($rhs->getRationalNumber());
        $this->exponentiation*=$rhs->getExponentiation();
        return $this;
    }

    public function copy(){
        return new PolynomialSummand($this->getNumber(), $this->getExponentiation(), $this->getVariable());
    }
}