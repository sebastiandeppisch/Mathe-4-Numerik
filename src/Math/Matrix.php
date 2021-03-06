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
        $this->data[$i][$j]=Number::fromString($number);
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
        $number = Number::fromString($number);
        for($j=0;$j<$this->getNCols();$j++){
            $this->get($i, $j)->mul($number);
        }
        return $this;
    }

    public function mulScalar($number):Matrix{
        $number = Number::fromString($number);
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

	public static function fromArray(array $newData):Matrix{
		$rows = count($newData);
		$cols = null;
		foreach($newData as $data){
			if($cols === null){
				$cols=count($data);
			}elseif($cols != count($data)){
				throw new Exception("Array not wellformed!");
			}
		}
		$matrix = new Matrix($rows, $cols);
		$matrix->setArray($newData);
		return $matrix;
	}

	public function setIdentity(){
		for($i=0;$i<$this->rows;$i++){
			for($j=0;$j<$this->cols;$j++){
				if($j===$i){
					$this->set($i, $j, new RationalNumber(1));
				}else{
					$this->set($i, $j, new RationalNumber(0));
				}
			}
		}
	}

	public function toHTML(){
		$html = '<div class="matrix">';
		$html.='<div class="fontMaxSize"></div>';
		$html .= "<table><tbody>";
		for($i=0;$i<$this->getNRows();$i++){
			$html.="<tr>";
			for($j=0;$j<$this->getNCols();$j++){
				$html.="<td>".$this->get($i, $j)->toHTML()."</td>";
			}
			$html.="</tr>";
		}
		$html .="</tbody></table>";
		$html .="</div>";
		return $html;
    }
    
    public function toFloat():Matrix{
        for($i=0;$i<$this->rows;$i++){
            for($j=0;$j<$this->cols;$j++){
                $this->set($i, $j, $this->get($i, $j)->toFloat());
            }
        }
        return $this;
    }

	public function __toString(): string {
		$result = "";
		$cols = [];
		for($i=0;$i<$this->getNRows();$i++){
			$cols[] = implode("\t", array_map(function($number){
					return $number->toString();
			}, $this->data[$i]));
		}
		return "\n".implode("\n", $cols)."\n";
	}

	public function __clone(){
		for($i=0;$i<$this->getNRows();$i++){
			for($j=0;$j<$this->getNCols();$j++){
				$this->data[$i][$j]=clone $this->data[$i][$j];
			}
		}
	}
}