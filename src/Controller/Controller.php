<?php 
namespace Controller;
abstract class Controller{

	static protected $controller=["PolynomExampleController"];

	static protected $inputFields=NULL;
	protected $data=[];

	protected $parameters;
	public function setData($parameters){
		$this->parameters=$parameters;
		foreach(static::$inputFields as $field){
			if(isset($parameters[$field["name"]])){
				$parameter = $parameters[$field["name"]];
			}else{
				$parameter = "";
			}
			$data = $parameter;
			switch($field["type"]){
				case "polynom":
					$p = new \Math\Polynomial();
					$p->addString($parameter);
					$data=$p;
				break;
				case "function":
					$data = new \Math\MFunction($parameter);
				break;
			}
			$this->data[$field["name"]]=$data;
		}
	}

	public function getInputHTML(){
		$html='<form>';
		foreach(static::$inputFields as $field){
			$input="";
			if(isset($this->parameters[$field["name"]])){
				$input=' value="'.$this->parameters[$field["name"]].'"';
			}
			$html.='<div class="form-group"><label for="'.$field["name"].'">'.$field["description"].'</label>';
			$html.='<input type="text" class="form-control" id="'.$field["name"].'" name="'.$field["name"].'"'.$input.'>';
			$html.='</div>';
		}		
		$html.='<button class="btn btn-primary btn-block">Berechnen</button>';
		$html.='</form>';
		return $html;
	}

	static public function get($name){
		if(in_array($name, self::$controller)){
			return new $$name;
		}
	}

	abstract function getOutputHTML();
}