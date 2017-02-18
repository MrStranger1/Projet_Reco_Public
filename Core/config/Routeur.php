<?php 
/**
* Class Router::sert à crer des routes, url
*/

class Router
{

/**
 * [url donner une url]
 * @param  [array] $options [tableau des options]
 * @param  [string] $url     [url a passer]
 * @return [string]          [retourne l'url]
 */
	public static function url($url)
	{
		$controller = isset($url['controller']) ? $url['controller'] 	: $_GET['controller'];
		$action 	= isset($url['action']) 	? $url['action'] 		: $_GET['action'];
		return $controller.'-'.$action;
	}

/**
 * [link passer un lien]
 * @param  [array] $options [tableau des options]
 * @param  [string] $url     [url a passer]
 * @param  [string] $slug    [texte de du lien]
 * @return [string]          [retourne le lien]
 */
	public static function link($url, $slug, array $options = null)
	{
		$controller = isset($url['controller']) ? $url['controller'] 	: $_GET['controller'];
		$action 	= isset($url['action']) 	? $url['action'] 		:  $_GET['action'];
		$params = '';
		if (isset($options)) {
			foreach ($options as $key => $value) {
				$params .= $key.'="'.$value.'"';
			}
		}
		return '<a class="redir" href="'.$controller.'-'.$action.'" '.$params.'>'.$slug.'</a>';

	}

/**
 * [redirect permet de rediriger]
 * @param  [array|string] $url [url a appeller]
 * @return [header]      [retourne sur la page demander]
 */
	public static function redirect($url)
	{
		$controller = isset($url['controller']) ? $url['controller'] : $_GET['controller'];
		$action = isset($url['action']) ? $url['action'] :  $_GET['action'];
		header('Location:'.$controller.'-'.$action);
		exit;
	}
}