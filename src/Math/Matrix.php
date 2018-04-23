<?php 
namespace Math;
class Matrix{
    protected $data=array();

    protected $rows;

    protected $cols;

    public function __construct(int $rows, int $cols){
        $this->rows=$rows;
        $this->cols=$cols;
        for($i=0;$i<$rows;$i++){
            $data[$i]=[];
        }
    }

    public function checkCoordiantes(int $i, int $j){

    }

    public function set(int $i, int $j, $number){
        $this->checkCoordiantes($i, $j);
        $this->data[$i][$j]=$this->convertNumber($number);
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

    public function get(int $i, int $j){
        $this->checkCoordiantes($i, $j);
        return $this->data[$i][$j];
    }

    public function setArray(array $newData){
        if(count($newData) != $this->rows){
            throw new \Exception("wrong rows count");
        }
        for($i=0;$i<$this->rows;$i++){
            for($j=0;$j<$this->cols;$j++){
                $this->set($i, $j, $newData[$i][$j]);
            }
        }
    }
}