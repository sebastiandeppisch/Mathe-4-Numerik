<?php
namespace Controller;
class MainController{

	private $currentActive="lorem";

	private static $menu=[
		"test",
		"lorem",
		"ipsum"
	];

	public function getInputHTML(){
		return "INPUT";
	} 

	public function getOutputHTML(){
		return "OUTPUT";
	}


	public function getMenuHTML(){
		$html = '<ul class="nav nav-sidebar">';

		foreach(self::$menu as $menu){
			$html.='<li '.(($menu === $this->currentActive)?' class="active"':'').'><a href="?controller='.$menu.'">'.$menu.'</a></li>';
		}

		$html.= '</ul>';
		return $html;
	}
}