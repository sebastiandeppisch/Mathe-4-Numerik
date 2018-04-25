<?php
namespace Math;

class SystemOfLinearEquations{
	private $matrix;
	private $vector;
	private $variables;

	public function __construct(Matrix $matrix, Vector $right, array $variables=[]){
		if($matrix->getNRows() !== $right->getNRows()){
			throw new \Exception("TODO");
		}
		$this->matrix=$matrix;
		$this->vector=$right;

		if(count($variables) === 0){
			for($i=0;$i<$right->getNRows();$i++){
				$this->variables[$i]="x_".$i;
			}
		}
	}

	public function elliminate(){
		for($i=0;$i<$this->matrix->getNRows()-1;$i++){
			$a = $this->matrix->get($i, $i);
			for($j=$i+1;$j<$this->matrix->getNRows();$j++){
				$b = $this->matrix->get($j, $i);
				$x = $this->getElliminateFactor($a, $b);
				$this->addRow($j, $i, $x);
			}
		}
	}
	
	static public function getElliminateFactor(Number $a, Number $b):Number{
		return $b->negate()->mul($a->reciprocal());
	}

	public function addRow(int $a, int $b, Number $mul=null){
		if($mul===null){
			$mul=new RationalNumber(1);
		}
		for($i=0;$i<$this->matrix->getNCols();$i++){
			$this->matrix->get($a, $i)->add($this->matrix->get($b, $i)->copy()->mul($mul));
		}
		$this->vector->get($a)->add($this->vector->get($b)->copy()->mul($mul));
	}

	public function getMatrix():Matrix{
		return $this->matrix;
	}
}