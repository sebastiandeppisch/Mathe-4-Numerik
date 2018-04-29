<?php
namespace Controller;
use Math\MFunction;
use \Khill\Lavacharts\Lavacharts;
use Math\EvaluatableFloat;
class ChartController{
	private $charts=array();

	private $from=0;

	private $to=1;

	private $label;

	public function __construct($name="Chart"){
		$this->label=$name;
	}

	public function addChart(EvaluatableFloat $func, $name){
		$chart = new \stdClass();
		$chart->func=$func;
		$chart->name=$name;
		$this->charts[]=$chart;
		return $this;
	}

	public function setFrom($from){
		$this->from=$from;
		return $this;
	}

	public function setTo($to){
		$this->to=$to;
		return $this;
	}

	private static $lava=null;

	public function getHTML(){
		if(self::$lava === null){
			self::$lava = new \Khill\Lavacharts\Lavacharts;
		}
		$lava = self::$lava;

		$chart = $lava->DataTable();

		$chart->addNumberColumn('Y');
		foreach($this->charts as $c){
			$chart->addNumberColumn($c->name);
		}
		for($i=$this->from*100;$i<=$this->to*100;$i++){
			$charts=[];
			$charts[]=$i/100;
			foreach($this->charts as $c){
				$y = $c->func->evaluate($i/100);
				if($y !== null){
					$charts[]=$y;
				}
				
			}
			$chart->addRow($charts);
		}
		$lava->LineChart($this->label, $chart);

		$id = 'chart'.uniqid();

		$html='<div id="'.$id.'" style="height:500px"></div>';
		$html.=$lava->render('LineChart', $this->label, $id);
		return $html;
	}
}