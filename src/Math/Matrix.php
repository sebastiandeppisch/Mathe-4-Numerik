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
        if($i >= $this->rows){
            throw new \Exception("out of row-boundary".$i);
        }
        if($j >= $this->cols){
            throw new \Exception("out of col-boundary".$j);
        }
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

    public function getArray(){
        return $this->data;
    }

    public function getTransposed(): Matrix{
        $transposed = new Matrix($this->cols, $this->rows);
        for($i=0;$i<$this->rows;$i++){
            for($j=0;$j<$this->cols;$j++){
                $transposed->set($j, $i, $this->get($i, $j));
            }
        }
        return $transposed;
    }

    public function getNRows(){
        return $this->rows;
    }

    public function getNCols(){
        return $this->cols;
    }

    public function mul(Matrix $rhs):Matrix{
        $result = new Matrix($this->getNRows(), $rhs->getNCols());
        for($i=0;$i<$result->getNRows();$i++){
            for($k=0;$k<$result->getNCols();$k++){
                $result->set($i, $k, self::getC($this, $rhs, $i, $k));
            }
        }

        return $result;
    }

    static public function getC(Matrix $a, Matrix $b, int $i, int $k):Number{
        if($b->getNRows() != $a->getNCols()){
            throw new \Exception("TODO");
        }
        $c=new RationalNumber(0);
        for($j=0;$j<$a->getNCols();$j++){
            $a_ij=$a->get($i, $j)->copy();
            $b_jk=$b->get($j, $k)->copy();
            $c->add($a_ij->mul($b_jk));
        }
        return $c;
    }

    public function mulScalarRow($i, $number):Matrix{
        $number = $this->convertNumber($number);
        for($j=0;$j<$this->getNCols();$j++){
            $this->get($i, $j)->mul($number);
        }
        return $this;
    }

    public function mulScalar($number):Matrix{
        $number = $this->convertNumber($number);
        for($i=0;$i<$this->getNRows();$i++){
            $this->mulScalarRow($i, $number);
        }
        return $this;
    }

    public function exchangeRows($a, $b):Matrix{
        $temp = $this->data[$a];
        $this->data[$a]=$this->data[$b];
        $this->data[$b]=$temp;
        return $this;
    }

    public function setZero(){
        for($i=0;$i<$this->rows;$i++){
            for($j=0;$j<$this->cols;$j++){
                $this->set($i, $j, new RationalNumber(0));
            }
        }
    }
}