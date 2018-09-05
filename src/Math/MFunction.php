<?php
namespace Math;
class MFunction implements EvaluatableFloat{
	private $func;

	static $eval=false;
	public function __construct(string $func){
		$e = exp(1);
		$func = preg_replace("/([0-9]+)(x)/", "$1*$2", $func);
		$func = preg_replace("/\(([0-9]+)\/([0-9]+)\)(x)/", "($1/$2)*x", $func);
		$func = preg_replace("/(x)\^([0-9]+)/", "pow($1,$2)", $func);
		$func = preg_replace("/(e)\^([0-9]+)/", "pow(e,$2)", $func);
		$func = str_replace("exp", "ep", $func);
		$this->func=$func;
		if(self::$eval === false){
			eval('function ep($v){return exp($v);}');
			self::$eval = true;
		}
		
	}

	private function executeEquation($equation){
		// Remove whitespaces
		$equation = preg_replace('/\s+/', '', $equation);
		
		$equation = str_replace("--","+",$equation);

		$regexp = '/^([+-]?(((?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?|pi|π)|(?:sinh?|cosh?|tanh?|acosh?|asinh?|atanh?|exp|ep|log(10)?|deg2rad|rad2deg|sqrt|pow|abs|intval|ceil|floor|round|(mt_)?rand|gmp_fact)\s*\((?1)+\)|\((?1)+\))(?:[\/*\^\+-,](?1))?)+$/';
		if (preg_match($regexp, $equation)){
			$equation = preg_replace('!pi|π!', 'pi()', $equation);
			eval('$result = '.$equation.';');
		}else{
			throw new \Exception('Invalid equation:""'.$equation.'"');
		}
		return $result;
	}

	public function evaluate(float $value):float{
		$func = $this->func;
		$func = str_replace("x", $value, $func);
		//$func = preg_replace("/(\-?[0-9]+(?:\.[0-9]+)?)\^([0-9]+)/", "pow($1,$2)", $func);
		return $this->executeEquation($func);
	}

	public function toString(){
		return $func;
	}
}