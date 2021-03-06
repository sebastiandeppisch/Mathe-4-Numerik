<?php
namespace Math;

abstract class PolynomialSummand{
    protected $variable;

    protected $exponentiation;

    protected $number;

    abstract protected function __construct($number, $exponentiation=0, $variable="x");

    static public function new($number, $exponentiation=0, $variable="x"){
        $number = Number::fromString($number);
        if($number instanceof RationalNumber){
            return new RPolynomialSummand($number, $exponentiation, $variable);
        }else{
            return new FPolynomialSummand($number, $exponentiation, $variable);
        }
    }

    public function add(PolynomialSummand $rhs){
        if($rhs->getVariable() !== $this->getVariable()){
            throw new Exception\PolynomialSummand\WrongVariable();
        }
        if($rhs->getExponentiation() !== $this->getExponentiation()){
            throw new Exception\PolynomialSummand\WrongExponentiation();
        }
        $this->getNumber()->add($rhs->getNumber());
    }

    public function getExponentiation(){
        return (int) $this->exponentiation;
    }

    public function getNumber(){
        return $this->number;
    }

    public function getVariable(){
        return $this->variable;
    }

    abstract public function evaluate($value);

    public function mul(PolynomialSummand $rhs):PolynomialSummand{
        if($rhs->getVariable() !== $this->getVariable()){
            throw new Exception\PolynomialSummand\WrongVariable();
        }
        $a=$this->copy();
        $a->number->mul($rhs->getNumber());
        $a->exponentiation+=$rhs->getExponentiation();
        return $a;
    }

    abstract public function divNumber($number);

    public function copy(){
        return new static($this->getNumber()->copy(), $this->getExponentiation(), $this->getVariable());
    }

    abstract public function toString();

    public function signed(){
        return $this->number()->signed();
    }

    public function toInnerHTML($signed=true){
        $number = $this->getNumber()->toHTML($signed);
        if($this->exponentiation !== 1){
            $variableAndExponent=sprintf("%s<sup>%s</sup>", $this->variable, $this->exponentiation);
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

    public function toHTML($signed=true){
        return '<div class="polynomialsummand">'.$this->toInnerHTML($signed).'</div>';
    }

    public function derivate():PolynomialSummand{
        $number = $this->getNumber()->copy()->mul(new RationalNumber($this->getExponentiation()));
        $exp = $this->getExponentiation()-1;
        $s = $this->copy();
        $s->number=$number;
        $s->exponentiation=$exp;
        return $s;
    }
}