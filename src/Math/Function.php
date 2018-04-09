<?php
class MFunction implements Evaluatable{
	private $func;
	public function __construct(string $func){
		$this->func=$func;
	}

	private function executeEquation($equation){
		// Remove whitespaces
		$equation = preg_replace('/\s+/', '', $equation);
		
		$equation = str_replace("--","+",$equation);

		$regexp = '/^([+-]?(((?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?|pi|π)|(?:sinh?|cosh?|tanh?|acosh?|asinh?|atanh?|exp|log(10)?|deg2rad|rad2deg|sqrt|pow|abs|intval|ceil|floor|round|(mt_)?rand|gmp_fact)\s*\((?1)+\)|\((?1)+\))(?:[\/*\^\+-,](?1))?)+$/';

		if (preg_match($regexp, $equation)){
			$equation = preg_replace('!pi|π!', 'pi()', $equation);
			eval('$result = '.$equation.';');
		}else{
			throw new Exception('Invalid equation:""'.$equation.'"');
		}
		return $result;
	}

	public function evaluate($value):int{
		$func = str_replace("x", $value, $this->func);
		return executeFunction($func);
	}
}