<?php
namespace Math;
class OneDimensionalTestSeries{
    private $data;
    public function __construct(array $data){
        foreach($data as &$number){
            $number = $this->convertNumber($number);
        }
        usort($data, function(Number $a, $b){
            $a=$a->evaluate();
            $b=$b->evaluate();
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });
        $this->data=$data;
    }

    public function getData(){
        return $this->data;
    }

    public function convertNumber($number):Number{
        if($number instanceof Number){
            return $number;
        }
        if(is_float($number)){
            return new FloatNumber($number);
        }
        if(is_int($number)){
            return new RationalNumber($number);
        }
        throw new \Excpetion($number." is not a correct number");
    }
}