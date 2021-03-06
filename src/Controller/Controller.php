<?php 
namespace Controller;
use Math\Matrix;
use Math\Number;
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
				$parameter = $field["default"];
				$this->parameters[$field["name"]]=$parameter;
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
				case "array":
					$ps = explode(",", $parameter);
					$data=[];
					foreach($ps as $number){
						$data[] = Number::fromString($number);
					}
				break;
				case "matrix":
					$rows =count($parameter);
					$cols = count($parameter[0]);
					$matrix = new Matrix($rows, $cols);
					$matrix->setArray($parameter);
					$data=$matrix;
				break;
			}
			$this->data[$field["name"]]=$data;
		}
	}

	public function getConditionsHTML(){
		$html="<script>";

		$changeableFields=array();
		$parameters=array();
		foreach(static::$inputFields as $field){
			if(isset($field["show"])){
				$p = new \stdClass();
				$p->field=$field["name"];
				$p->show=[];
				foreach($field["show"] as $condition){
					$changeableFields[]=$condition["name"];
					$s = new \stdClass();
					$s->name=$condition["name"];
					$s->value=$condition["value"];
					$p->show[]=$s;
				}
				$parameters[]=$p;
				
			}
		}
		$changeableFields=array_unique($changeableFields);
		foreach($changeableFields as $field){
			$html.='$("#'.$field.'").change(function(){toggleFields();});';
		}
		$html.="var parameters=".json_encode($parameters).";";
		$html.="</script>";
		return $html;
	}

	public function getInputHTML(){
		$html='<form>';
		foreach(static::$inputFields as $field){
			switch($field["type"]){
				case "select":
					$html.='<div class="form-group"><label for="'.$field["name"].'">'.$field["description"].'</label>';
					$html.='<select class="form-control" id="'.$field["name"].'" name="'.$field["name"].'">';
					foreach($field["values"] as $key => $value){
						if(isset($this->parameters[$field["name"]]) && $this->parameters[$field["name"]]==$key){
							$html.='<option value="'.$key.'" selected>'.$value.'</option>';
						}else{
							$html.='<option value="'.$key.'">'.$value.'</option>';
						}
					}
					$html.='</select></div>';
				break;
				case "matrix":
					if(is_array($this->parameters[$field["name"]])){
						$rows = 0;
						$cols = 0;
						$data =[];
						foreach($this->parameters[$field["name"]] as $i => $row){
							foreach($row as $j => $cell){
								$rows=$i;
								$cols=$j;
								$data[]=$cell;
							}
						}
						$rows++;
						$cols++;
						$this->parameters[$field["name"]]=$rows.";".$cols.";".implode(",", $data);
					}
					
					$html.='<div data-name="'.$field["name"].'" class="matrix-input" data-init="'.$this->parameters[$field["name"]].'"></div>';
				break;
				default: 
					$input="";
					if(isset($this->parameters[$field["name"]])){
						$input=' value="'.$this->parameters[$field["name"]].'"';
					}
					$html.='<div class="form-group"><label for="'.$field["name"].'">'.$field["description"].'</label>';
					$html.='<input type="text" class="form-control" id="'.$field["name"].'" name="'.$field["name"].'"'.$input.'>';
					$html.='</div>';
				break;
			}
		}		
		$html.='<button class="btn btn-primary btn-block">Berechnen</button>';
		$html.='</form>';
		$html.=$this->getConditionsHTML();
		return $html;
	}

	static public function get($name){
		if(in_array($name, self::$controller)){
			return new $$name;
		}
	}

	abstract function getOutputHTML();

	public function getChart(){
		return NULL;
	}
}