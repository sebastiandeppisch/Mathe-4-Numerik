<?php
namespace Controller;
class MainController{
	private $currentActive=NULL;

	private $controller=NULL;

	private static $menu=[
		"text-examples" => "Eingabe - Beispiele:",
		"PolynomExampleController" => "Polynom Formattierungs Beispiel",
		"FunctionExampleController" => "Funktionsauswertung Beispiel",
		"MatrixController" => "Matrix",
		"text-numeric" => "Numerik:",
		"LagrangeController" => "Lagrange Interpolation",
		"NewtonController" => "Newton Interpolation",
		"CubicSplinesController" => "Kubische Splines Interpolation",
		"NewtonCotesQuadraturController" => "Newton-Cotes-Quadratur",
		"ButcherTableController" => "Butcher Tableu",
		"CholeskyDecompositionController" => "Cholesky Zerlegung",
		"GaussAlgorithmController" => "Gauss Algorithmus",
		"text-stochastic" => "Stochastik:",
		"OneDimensionalTestSeriesController" => "1D Messreihe",
		"TwoDimensionalTestSeriesController" => "2D Messreihe",
	];

	private $error = NULL;

	public function __construct($controller){
		if($controller !== NULL){
			if(strpos($controller, 'Controller') !== false && in_array($controller, array_keys(self::$menu))){
				$test = new PolynomExampleController();
				$this->currentActive=$controller;
				$controller="\Controller\\".$controller;
				$this->controller = new $controller;
				try{
					$this->controller->setData($_GET);
				}catch(\Exception $e){
					$this->error= "Es ist ein Fehler aufgetreten:<br>".get_class($e)."<br>".$e->getMessage();
				}
				
			}
		}
	}

	public function getInputHTML(){
		if($this->controller !== NULL){
			return $this->controller->getInputHTML();
		}
	} 

	public function getOutputHTML(){
		if($this->error !== NULL){
			return $this->error;
		}
		if($this->controller !== NULL){
			try{
				$html =  $this->controller->getOutputHTML();
			}catch(\Exception $e){
				$html= "Es ist ein Fehler aufgetreten:<br>".get_class($e)."<br>".$e->getMessage();
			}
			return $html;
		}
	}

	public function getMenuHTML(){
		$html = '<ul class="nav nav-sidebar">';

		foreach(self::$menu as $controller => $label){
			if(strpos($controller, 'Controller') === false){
				$html.='<li class="disabled"><a href="#">'.$label.'</a></li>';
			}else{
				$html.='<li '.(($controller === $this->currentActive)?' class="active"':'').'><a href="'.$controller.'">'.$label.'</a></li>';
			}
		}

		$html.= '</ul>';
		return $html;
	}

	public static function getControllerNames(){
		return array_keys(self::$menu);
	}

	public function getChartHTML(){
		if($this->controller !== NULL && $this->controller->getChart() !== NULL){
			if(is_array($this->controller->getChart())){
				$html = "";
				foreach($this->controller->getChart() as $chart){
					$html.=$chart->getHTML();
				}
				return $html;
			}else{
				if(is_string($this->controller->getChart())){
					return $this->controller->getChart();
				}
				return $this->controller->getChart()->getHTML();
			}
			
		}
		return NULL;
	}
}