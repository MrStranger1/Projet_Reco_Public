<?php 
/**
* Class Controllers::gere
*/

class Controllers
{
/**
 * [$viewPath chemin du fichier vues]
 * @var [type]
 */
	private 	$viewPath;
	private 	$vars = [];
	private 	$rendered = false;
	public 		$components = array();
	public 		$request;
	protected 	$template;
	public 		$action;
	
	public function __construct(Request $request)
	{
		preg_match('/[a-z]+/', get_class($this), $matches);
		$this->viewPath = 'views/'.$this->viewPath.ucfirst($matches[0]) .'s/';
		$this->request = $request;
		$this->template = trim($this->template);
	}

/**
 * [render fonction de rendu de page + variables]
 * @param  [string] $view      [fichier a appeller]
 * @param  array  $variables [variables a passer en parametre]
 * @return [(object)]            [retourne le fichier appeler]
 */
	public function render($view){	

		if($this->rendered){return false;}
		if (isset($this->template) && !empty($this->template)) { //existe
			ob_start();
			extract($this->vars);
			if (file_exists($this->viewPath.$view.'.php')) {
				require $this->viewPath.$view. '.php';
				$content_for_layout = ob_get_clean();
				require 'views/templates/'.$this->template.'.php';
			}else{
				$this->notFound();
			}
		}else{
			if (file_exists($this->viewPath.$view.'.php')) {
				require $this->viewPath.$view. '.php';
			}else{
				$this->notFound();
			}
		}
		$this->rendered = true;
	}

	public function set($key, $valeur = null)
	{
		if(is_array($key)){
			$this->vars += $key;
		}else{
			$this->vars[$key] = $valeur;
		}
	}
	
/**
 * [notFound fonction de page introuvable]
 * @return [die] [retourne page introuvable]
 */
	public static function notFound()
	{
		header('HTTP/1.0 404 not Found');
		die('<h1>Page introuvable </h1>');
	}

/**
 * [forbiden fonction de page oublier]
 * @return [type] [description]
 */
	protected static function forbiden()
	{
		header('HTTP/1.0 403 not Found');
		die("<h1>Accès interdit !</h1>");
	}

/**
 * [with permet de vérifier le parametre valide]
 * @param  [regex] $pattern [pattern a utiliser]
 * @param  [string] $field   [champs à vérifier]
 * @return [bool]          [retourne true ou false]
 */
	public function with($pattern, $field){

		if(isset($field) && !empty($field) && $field !== null){
			if(preg_match($pattern, $field, $matches)){
				return true;
			}else{
				return false;
			}
		}
	}


/**
 * [loadModel charger les modeles tables]
 * @param  [string] $model_name [table a charger]
 * @return [object]             [retourne linstance de la table]
 */
	public function loadModel()
	{
		preg_match('/[a-z]+/', get_class($this), $matches);
		$model_name = ucfirst($matches[0]);

		$files = dirname(dirname(__DIR__)) . '\\models\\';
		if (!isset($this->$model_name)) {
			require_once $files.$model_name.'.php';
			$this->$model_name = new $model_name();
			if (isset($this->Form)) {
				$this->$model_name->Form = $this->Form;
			}
		}

	}


/**
 * [loadComponents charge les composant]
 * @param  [type] $controller [description]
 * @return [type]             [description]
 */
	public function loadComponents($controllers)
	{
		$files = 'core/controllers/components/';
		if(!empty($this->components)){
			$file;
			$params = null;
			foreach ($this->components as $key => $value) {
				if (is_string($key)) {
					$file = $key;
					$params = $value;
				} else {
					$file = $value;
					$params = array();
				}
				$file = ucfirst($file);

				if ($file === 'Form') {
					require 'components/ErrorHandler.php';
					require 'components/Validator.php';
					$db = new Models('sd');
					$errorHandler = new ErrorHandler();
					$validator = new Validator($errorHandler, $db);

					$params = array(
							'errorHandler'=> $errorHandler,
							'validator' =>$validator
						);
				}elseif ($file === 'Auth') {
					$db = new Models();
					$session = $this->Session;
					$params = array(
							'db' 		=> $db,
							'session'	=> $session,
							'configs'	=> $params,
							'url'		=> $this->request->url
						);
				}
				require_once $files.$file.'.php';
				$controllers->$file = new $file($params);
			}
			return $controllers;
		}
		
	}
}