<?php 
/**
* Class Dispacher::appeller les controlleur et les méthode dynamiquement
*/
class Dispatcher
{
	private $request;

	function __construct()
	{
		$this->request = new Request();
		$this->parse();
		$controller = $this->loadController();
		if(!in_array($this->request->action, array_diff(get_class_methods($controller), get_class_methods('Controllers')))){
			echo 'Le controller '.$this->request->controller . ' n\'a pas de méthode '.$this->request->action;
			$this->notFound();
		}else{
			call_user_func_array(array($controller, $this->request->action), $this->request->params);
			return $controller->render($this->request->action);
		}
	}

	public function parse()
	{

		$this->request->url = trim($this->request->url);
		$this->request->url = preg_replace('/[\-]+$/', '', $this->request->url);
		$pattern = explode('-', $this->request->url);
		$this->request->controller  = $pattern[0];
		$this->request->action 		= isset($pattern[1]) ? $pattern[1] : 'index';
		$this->request->params 		= array_slice($pattern, 2);
		$this->request->time 		= date('Y-m-d G:i:s');
		$this->request->base 		= basename(dirname(dirname(dirname(__FILE__))));
		if(!empty($this->request->params)){
			return $this->request->params;
		}else{
			return $this->request->params = array();
		}
	}

	public function loadController()
	{
		$name = $this->request->controller.'Controllers';
		$file = 'controllers/'.$name .'.php';
		if(!file_exists($file)){
			return $this->notFound();
		}
		require $file;
		$controller = new $name($this->request);
		$controller->loadComponents($controller);
		$controller->loadModel();
		return $controller;
	}

	public function notFound()
	{
		header('HTTP/1.0 404 not Found');
		die('<h1>Page introuvable</h1>');
	}
}

