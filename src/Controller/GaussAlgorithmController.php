<?php 
namespace Controller;

use Math\Matrix;
use Math\Vector;
use Math\GaussAlgorithm;

class GaussAlgorithmController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"matrix",
			"name"=>"matrix",
			"description"=>"Matrix",
			"default" => [[1,1,0,1,2],[1,2,1,0,5],[0,1,2,1,1], [1,0,1,2,-1]],
		]
	];

	private $a;
	private $b;

	public function setData($parameters){
		parent::setData($parameters);
		$n = $this->data["matrix"]->getNRows();
		$a = new Matrix($n, $n);
		$b = new Vector($n);
		for($i=0;$i<$n;$i++){
			for($j=0;$j<$n;$j++){
				$a->set($i, $j, $this->data["matrix"]->get($i, $j));
			}
			$b->set($i, $this->data["matrix"]->get($i, $n));
		}
		$this->a=$a;
		$this->b=$b;
	}

	public function getOutputHTML(){
		$n = $this->a->getNRows();
		$gauss = new GaussAlgorithm($this->a, $this->b);
		$html = '<table class="table">';
		$html .= '<thead><tr><th>k</th><th>A</th><th>b</th><th>L</th><th>P</th></tr></thead>';
		for($i=1;$i<=$n;$i++){
			$result = $gauss->solveLR($i);
			$html.='<tr>';
			$html.='<td>'.$i.'</td>';
			$html.='<td>'.$result->getR()->toHTML().'</td>';
			$html.='<td>'.$result->getC()->toHTML().'</td>';
			$html.='<td>'.$result->getL()->toHTML().'</td>';
			$html.='<td>'.$result->getP()->toHTML().'</td>';
			$html.='</tr>';
		}
		$html .='</table>';
		return $html;
	}
}