<?php
namespace Math;

class FPolynomialSummand{
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

    public function add(FPolynomialSummand $rhs){
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

    public function mul(FPolynomialSummand $rhs):FPolynomialSummand{
        if($rhs->getVariable() !== $this->getVariable()){
            throw new Exception\PolynomialSummand\WrongVariable();
        }
        $a=$this->copy();
        $a->rationalNumber->mul($rhs->getRationalNumber());
        $a->exponentiation+=$rhs->getExponentiation();
        return $a;
    }

    public function divNumber(int $number):FPolynomialSummand{
        $this->rationalNumber->mul(new RationalNumber(1, $number));
        return $this;
    }

    public function copy(){
        return new FPolynomialSummand($this->getRationalNumber()->copy(), $this->getExponentiation(), $this->getVariable());
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
        return $this->rationalNumber->getP() < 0;
    }

    public function toInnerHTML($signed=true){
        $rationalNumber = $this->getRationalNumber()->toHTML($signed);
        if($this->exponentiation !== 1){
            $variableAndExponent=sprintf("%s<sup>%s</sup>", $this->variable, $this->exponentiation);
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

    public function toHTML($signed=true){
        return '<div class="polynomialsummand">'.$this->toInnerHTML($signed).'</div>';
    }
}