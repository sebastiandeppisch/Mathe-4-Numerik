<?php
namespace Math;
class Polynomial{
    private $variable;

    private $summands=array();

    public function __construct($variable="x"){
        $this->variable=$variable;
    }


    public static function getFromString($string){

    }

    public function getDegree(){

    }

    public function mul($rhs){
        if(is_numeric($rhs)){
            $rhs = self::getFromNumber($rhs);
        }
    }

    public function mulPolynomial(Polynomial $polynomial){

    }

    public function add($rhs){
        if(is_numeric($rhs)){
            $rhs = self::getFromNumber($rhs);
        }
    }

    public function addPolynomial(Polynomial $polynomial){

    }

    private function handleInvariant(){

    }
    
}