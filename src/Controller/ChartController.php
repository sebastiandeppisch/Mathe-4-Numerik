<?php
namespace Controller;
use Math\MFunction;
use \Khill\Lavacharts\Lavacharts;
class ChartController{
	private $charts=array();

	private $from=0;

	private $to=1;

	private $label;

	public function __construct($name="Chart"){
		$this->label=$name;
	}

	public function addChart(MFunction $func, $name){
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

	public function getHTML(){
		$lava = new \Khill\Lavacharts\Lavacharts;

		$chart = $lava->DataTable();

		$chart->addNumberColumn('Y');
		foreach($this->charts as $c){
			$chart->addNumberColumn($c->name);
		}
		for($i=$this->from*100;$i<=$this->to*100;$i++){
			$chart->addRow([$i/100, $this->charts[0]->func->evaluate($i/100), $this->charts[1]->func->evaluate($i/100)]);
		}
		$lava->LineChart($this->label, $chart);

		$html='<div id="chart" style="height:500px"></div>';
		$html.=$lava->render('LineChart', $this->label, 'chart');
		return $html;
	}
}