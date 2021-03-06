<?php 
namespace Math;
class Vector{
    protected $data=array();

    protected $rows;

    public function __construct(int $rows){
        $this->rows=$rows;
    }

    public function checkCoordiantes(int $i){
        if($i >= $this->rows){
            throw new \Exception($i. "> ".$this->rows);
        }
    }

    public function set(int $i, $number){
        $this->checkCoordiantes($i);
        $this->data[$i]=Number::fromString($number);
    }

    public function get(int $i):Number{
        $this->checkCoordiantes($i);
        return $this->data[$i];
    }

    public function setArray(array $newData){
        if(count($newData) != $this->rows){
            throw new \Exception("wrong rows count");
        }
        for($i=0;$i<$this->rows;$i++){
            $this->set($i, $newData[$i]);
        }
    }

    static public function fromArray(array $newData):Vector{
        $vector = new Vector(count($newData));
        $vector->setArray($newData);
        return $vector;
    }

    public function getArray(){
        return $this->data;
    }

    public function getNRows(){
        return $this->rows;
    }


    public function mulScalarRow($i, $number):Vector{
        $number = Number::fromString($number);
        $this->get($i)->mul($number);
        return $this;
    }

    public function mulScalar($number):Vector{
        $number = Number::fromString($number);
        for($i=0;$i<$this->getNRows();$i++){
            $this->mulScalarRow($i, $number);
        }
        return $this;
    }

    public function dotProduct($rhs):Number{
        $result=null;
        for($i=0;$i<$this->getNRows();$i++){
            $r = $this->get($i)->mul($rhs->get($i));
            if($result == null){
                $result = $r;
            }else{
                $result->add($r);
            }
        }
        return $result;
    }

    public function crossProduct(Vector $b):Vector{
        $result = new Vector(3);
        $a=$this;

        $l=$a->get(1)->copy()->mul($b->get(2));
        $r=$a->get(2)->copy()->mul($b->get(1))->mul(new RationalNumber(-1));
        $result->set(0, $l->add($r));

        $l=$a->get(2)->copy()->mul($b->get(0));
        $r=$a->get(0)->copy()->mul($b->get(2))->mul(new RationalNumber(-1));
        $result->set(1, $l->add($r));

        $l=$a->get(0)->copy()->mul($b->get(1));
        $r=$a->get(1)->copy()->mul($b->get(0))->mul(new RationalNumber(-1));
        $result->set(2, $l->add($r));
        return $result;
    }

    public function exchangeRows($a, $b):Vector{
        $temp = $this->data[$a];
        $this->data[$a]=$this->data[$b];
        $this->data[$b]=$temp;
        return $this;
    }

    public function toMatrix():Matrix{
        $m = new Matrix($this->getNRows(), 1);
        for($i=0;$i<$this->getNRows();$i++){
            $m->set($i, 0, $this->get($i)->copy());
        }
        return $m;
    }

    public function toHTML(){
		$html = '<div class="vector">';
		$html.='<div class="fontMaxSize"></div>';
		$html .= "<table><tbody>";
		for($i=0;$i<$this->getNRows();$i++){
			$html.="<tr>";
            $html.="<td>".$this->get($i)->toHTML()."</td>";
			$html.="</tr>";
		}
		$html .="</tbody></table>";
		$html .="</div>";
		return $html;
	}
}