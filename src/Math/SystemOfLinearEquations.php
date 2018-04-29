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
			$this->variables=[];
			for($i=0;$i<$right->getNRows();$i++){
				$this->variables[$i]="x_".$i;
			}
		}else{
			$this->variables=$variables;
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

	private $solution=null;

	public function solve():array{
		if($this->solution !== null){
			return $this->solution;
		}
		$this->elliminate();
		$result=[];
		for($i=$this->matrix->getNRows()-1;$i>=0;$i--){
			$number = $this->vector->get($i);
			for($j=$this->matrix->getNRows()-1;$j>$i;$j--){
				$c = $this->matrix->get($i, $j);
				$number->add($c->mul($result[$j])->negate());
			}
			$number=$number->mul($this->matrix->get($i, $i)->reciprocal());
			$result[$i]=$number;
		}
		$this->solution=$result;
		return $result;
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

	public function getVector():Vector{
		return $this->vector;
	}

	public function toHTML(){
		$html = '<div class="systemoflinearequations">';
		
		$html.='<div class="fontMaxSize"></div>';
		$html .= "<table><tbody>";

		for($i=0;$i<$this->matrix->getNRows();$i++){
			$html.="<tr>";
			if($i==0){
				$html.="<td rowspan=".$this->matrix->getNRows().">(</td>";
			}
			
			for($j=0;$j<$this->matrix->getNCols();$j++){
				$html.="<td>".$this->matrix->get($i, $j)->toHTML()."</td>";
			}

			if($i==0){
				$html.="<td rowspan=".$this->matrix->getNRows().">)</td>";
				$html.="<td rowspan=".$this->matrix->getNRows().">(</td>";
			} 

			$html.="<td>".$this->variables[$i]."</td>";
			if($i==0){
				$html.="<td rowspan=".$this->matrix->getNRows().">)</td>";
				$html.="<td rowspan=".$this->matrix->getNRows().">(</td>";
			} 
			$html.="<td>".$this->vector->get($i)->toHTML()."</td>";
			if($i==0){
				$html.="<td rowspan=".$this->matrix->getNRows().">)</td>";
			} 
	
			$html.="</tr>";
		}
		
		$html .="</tbody></table>";


		$html .="</div>";
		return $html;
	}

	public function getVariableHTML($i){
		return preg_replace("/([a-zA-Z]+)(?:_)([0-9]+)/", "$1<sub>$2</sub>", $this->variables[$i]);
	}

	public function solutionToHTML(){
		$solution = $this->solve();
		$html = "<div style='display:flex:'>";
		
		for($i=0;$i<count($solution);$i++){
			$html.="<div style='padding:10px;'>";
			$html.=$this->getVariableHTML($i);
			$html.="=";
			$html.=$solution[$i]->toHTML();
			$html.="</div>";
		}
		
		$html.="</div>";
		return $html;
	}
}