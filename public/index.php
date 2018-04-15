<?php 
	require_once(__DIR__."/../vendor/autoload.php");
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	$klein = new \Klein\Klein();
	$request = \Klein\Request::createFromGlobals();
		// Grab the server-passed "REQUEST_URI"
	$uri = $request->server()->get('REQUEST_URI');
	$baseURI =  dirname($_SERVER["SCRIPT_NAME"]);

	$klein->respond('GET', $baseURI.'/', function (){
		$controller = new \Controller\MainController(null);
		
		$loader = new Twig_Loader_Filesystem("../resources/views/");
		$twig = new Twig_Environment($loader);
		$template = $twig->load('page.twig');
		return $template->render([
			"menu" => $controller->getMenuHTML()
		]);
	});

	foreach(\Controller\MainController::getControllerNames() as $name){
		$klein->respond('GET', $baseURI.'/'.$name, function () use ($name){
			$controller = new \Controller\MainController($name);
			$loader = new Twig_Loader_Filesystem("../resources/views/");
			$twig = new Twig_Environment($loader);
			$template = $twig->load('page.twig');
			return $template->render([
				"menu" => $controller->getMenuHTML(),
				"input" => $controller->getInputHTML(),
				"output" => $controller->getOutputHTML(),
			]);
		});
	}
	$klein->dispatch();