<?php
namespace Math;
class Polynomial implements Evaluatable{
    private $variable;

    private $summands=array();

    public function __construct($variable="x"){
        $this->variable=$variable;
    }

    //internal 

    public function addSummand(PolynomialSummand $newSummand):Polynomial{
        foreach($this->summands as &$summand){
            if($summand->getExponentiation() === $newSummand->getExponentiation()){
                $summand->add($newSummand);
                return $this;
            }
        }
        $this->summands[]=$newSummand;
        return $this;
    }

    public function sort(){
        usort($this->summands, function($a, $b){
            $a=$a->getExponentiation();
            $b=$b->getExponentiation();
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
    }

    public function clear():Polynomial{
        $this->summands=[];
        return $this;
    }

    public function getSummands(){
        return $this->summands;
    }

    //string handling
    private function getRegex(){
        return sprintf('([+-]?(?:(?:\d+%s\^\d+)|(?:%s\^\d+)|(?:\d+%s)|(?:\d+)|(?:%s)))', $this->variable, $this->variable, $this->variable, $this->variable);
    }

    public function isParsable(string $formula): bool{
        $test = preg_match_all($this->getRegex(), $formula, $matches, PREG_SET_ORDER, 0);
        foreach($matches as $match){
            $formula = str_replace($match[0], "", $formula);
        }
        return strlen($formula) == 0;
    }

    public function addString(string $formula):Polynomial{ //TODO ugly code 
        preg_match_all($this->getRegex(), $formula, $matches, PREG_SET_ORDER, 0);
        foreach($matches as $match){
            $match = $match[0];
            $match = explode("x", $match);
            $number = $match[0];
            $exponentiation = 0;
            if($number==="" || $number==="+"){
                $number=1;
            }
            if($number==="-"){
                $number=-1;
            }
            if(count($match) > 1 && strlen($match[1]) > 1){
                $exponentiation = str_replace("^", "", $match[1]);
            }else{
                if(count($match) == 2){
                    $exponentiation = 1;
                }
            }
            $number = (int) $number;
            $this->addSummand(new \Math\PolynomialSummand($number, $exponentiation, $this->variable));
        }
        return $this;
    }

    public function toString():string{ //TODO ugly code 
        $this->sort();
        $result="";
        foreach($this->summands as $key => &$summand){
            if($key !== 0){
                $result.=(($summand->getNumber()< 0 )?"":"+");
            }
            if(! (abs($summand->getNumber()) == 1 && $summand->getExponentiation() !== 0)){
                $result.=$summand->getNumber();
            }else{
                if($summand->getNumber() == -1){
                    $result.="-";
                }
            }
            if($summand->getExponentiation() !== 0){
                if($summand->getExponentiation() ==1 ){
                    $result.=$summand->getVariable();
                }else{
                    $result.=$summand->getVariable()."^".$summand->getExponentiation();
                }
                
            }
        }
        if($result == ""){
            return "0";
        }
        return $result;
    }

    //multiplication

    public function mul(Polynomial $rhs):Polynomial{
        $p = new Polynomial($this->variable);
        foreach($this->summands as $a){
            foreach($rhs->getSummands() as $b){
                $a= $a->copy();
                $p->addSummand($a->mul($b));
            }
        }
        return $p;
    }

    //addition

    public function add(Polynomial $rhs):Polynomial{
        foreach($rhs->getSummands() as $summand){
            $this->addSummand($summand);
        }
        return $this;
    }

    public function addNumber(int $number):Polynomial{

    }


    // other stuff
    public function evaluate(int $value):int {
        $result = 0;
        foreach($this->summands as $summand){
            $result+=$summand->evaluate($value);
        }
        return $result;
    }

    public function toHTML():string{
        $data = $this->toString();
        return preg_replace("/\^([0-9+])/", "<sup>$1</sup>", $data);
    }
}