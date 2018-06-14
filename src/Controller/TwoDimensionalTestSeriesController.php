<?php 
namespace Controller;
use Math\TwoDimensionalTestSeries;
use Math\MFunction;
class TwoDimensionalTestSeriesController extends Controller{
	static protected $inputFields=[
		[
			"type"=>"array-rational",
			"name"=>"data-x",
			"description"=>"Werte",
			"default" => "1,2,3,4,5"
		],
		[
			"type"=>"array-rational",
			"name"=>"data-y",
			"description"=>"Werte",
			"default" => "1/2,2,3,5,7"
		]
	];
	
	private $testSeries;

	public function setData($parameters){
		parent::setData($parameters);
		$this->testSeries =	new TwoDimensionalTestSeries($this->data["data-x"], $this->data["data-y"]);
	}

	public function getOutputHTML(){
		$s = $this->testSeries;
		$html = "<ul>";
		$html.=sprintf("<li>Arithmetisches Mittel x : %s Float: %f</li>", $s->getArithmeticalAverageX()->toHTML(), $s->getArithmeticalAverageX()->evaluate());
		$html.=sprintf("<li>Arithmetisches Mittel y : %s Float: %f</li>", $s->getArithmeticalAverageY()->toHTML(), $s->getArithmeticalAverageY()->evaluate());

		$html.=sprintf("<li>Empirische Varianz X %s Float: %f</li>", $s->getEmpiricalVarianceX()->toHTML(), $s->getEmpiricalVarianceX()->evaluate());
		$html.=sprintf("<li>Empirische Varianz Y %s Float: %f</li>", $s->getEmpiricalVarianceY()->toHTML(), $s->getEmpiricalVarianceY()->evaluate());

		$html.=sprintf("<li>Empirische Streuung X: %s </li>", $s->getEmpirischeStreuungX()->toHTML());
		$html.=sprintf("<li>Empirische Streuung Y: %s </li>", $s->getEmpirischeStreuungY()->toHTML());

		$html.=sprintf("<li>Empirische Kovarianz s_xy: %s </li>", $s->getEmpirischeKovarianz()->toHTML());

		$html.=sprintf("<li>Empirischer Korrelationskoeffizient: %s </li>", $s->getEmpirischerKorrelationskoeffizient()->toHTML());

		$html.=sprintf("<li>Regressionsgerade: y=%sx+%s </li>", $s->getRegressionsGeradeA()->toHTML(), $s->getRegressionsGeradeB()->toHTML());
		$html.="</ul>";
		return $html;
	}

	public function getChart(){
		/*$charts=[];
		//https://github.com/kevinkhill/lavacharts/blob/3.0/tests/Examples/Charts/ComboChart.php
		$regression= new ChartController("Regressionsgerade");
		$regression->addChart(new MFunction("5x+7"), "Gerade");
		//$regression->setType("ScatterChart");
		$charts[]=$regression;
		return $charts;*/

		$lava = new \Khill\Lavacharts\Lavacharts;

		$finances = $lava->DataTable();
		$finances->addNumberColumn('Y')
				->addNumberColumn('Punkte')
				->addNumberColumn('Regressionsgerade');
			for($i=1;$i<=$this->testSeries->getN();$i++){
				$x = $this->testSeries->getXi($i)->evaluate();
				$y = $this->testSeries->getYi($i)->evaluate();

				$a = $this->testSeries->getRegressionsGeradeA()->evaluate();
				$b = $this->testSeries->getRegressionsGeradeB()->evaluate();

				$finances->addRow([$x, $y, $a*$x+$b]);
			}
		$lava->ComboChart('Finances', $finances, [
			'title' => 'Regression',
			'titleTextStyle' => [
				'color' => 'rgb(123, 65, 89)',
				'fontSize' => 16,
				'bold' => true
			],
			'legend' => [
				'position' => 'in'
			],
			'seriesType' => 'line',
			'series' => [
				1 => [
					'type' => 'line'
				]
			]
		]);
		return '<div id="finances-div" style="height:500px"></div>'.$lava->render('ComboChart', 'Finances', 'finances-div');
		/*
		$splines = $this->getSplines();
		$chart = new ChartController("Kubische Splines");
		$chartS = new ChartConTroller("S-Komplett");
		$chartD = new ChartController("Kubische Splines 1-fache Ableitung");
		$chartDD = new ChartController("Kubische Splines 2-fache Ableitung");
		$parts=[];
		$partsD=[];
		$partsDD=[];
		for($i=0;$i<$splines->getDegree();$i++){
			$from = $splines->getX($i)->evaluate();
			$to = $splines->getX($i+1)->evaluate();
			$spline = $splines->getS($i)->toString();
			$splineD= $splines->getS($i)->derivate()->toString();
			$splineDD= $splines->getS($i)->derivate()->derivate()->toString();
			$parts[]=new PartialMFunction(new MFunction($spline), $from, $to);
			$partsD[]=new PartialMFunction(new MFunction($splineD), $from, $to);
			$partsDD[]=new PartialMFunction(new MFunction($splineDD), $from, $to);
			$chartS->addChart(new MFunction($this->getSplines()->getS($i)->toString()), "s_".$i);
		}
		$chart->addChart(new \Math\MFunctionSet($parts), "s(x)");
		$chartD->addChart(new \Math\MFunctionSet($partsD), "s'(x)");
		$chartDD->addChart(new \Math\MFunctionSet($partsDD), "s''(x)");
		
		$charts[]=$chart;
		$charts[]=$chartS;
		$charts[]=$chartD;
		$charts[]=$chartDD;
		foreach($charts as &$c){
			$c->setFrom($this->data["xnodes"][0]->evaluate())
			->setTo(end($this->data["xnodes"])->evaluate());
		}*/
		$chartS->addChart(new MFunction($this->getSplines()->getS($i)->toString()), "s_".$i);
		return $charts;
	}
}