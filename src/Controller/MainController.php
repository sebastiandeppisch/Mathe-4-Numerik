<?php
namespace Controller;
class MainController{
	private $currentActive=NULL;

	private $controller=NULL;

	private static $menu=[
		"PolynomExampleController" => "Polynom Formattierungs Beispiel",
		"FunctionExampleController" => "Funktionsauswertung Beispiel"
	];

	public function __construct($controller){
		if($controller !== NULL){
			if(in_array($controller, array_keys(self::$menu))){
				$test = new PolynomExampleController();
				$this->currentActive=$controller;
				$controller="\Controller\\".$controller;
				$this->controller = new $controller;
				$this->controller->setData($_GET);
			}
		}
	}

	public function getInputHTML(){
		if($this->controller !== NULL){
			return $this->controller->getInputHTML();
		}
	} 

	public function getOutputHTML(){
		if($this->controller !== NULL){
			return $this->controller->getOutputHTML();
		}
	}

	public function getMenuHTML(){
		$html = '<ul class="nav nav-sidebar">';

		foreach(self::$menu as $controller => $label){
			$html.='<li '.(($controller === $this->currentActive)?' class="active"':'').'><a href="'.$controller.'">'.$label.'</a></li>';
		}

		$html.= '</ul>';
		return $html;
	}

	public static function getControllerNames(){
		return array_keys(self::$menu);
	}
}