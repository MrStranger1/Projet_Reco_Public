<?php 
/**
* Class Request::sert a stocker la requete
*/
class Request
{
	public $url;
	public $data = false;

	function __construct()
	{

		if(isset($_SERVER['REDIRECT_URL']) && !empty($_SERVER['REDIRECT_URL'])){
			
			$redirect = explode('/',$_SERVER['REDIRECT_URL']);
			$this->url = end($redirect);
	
		}
		if (!empty($_POST)) {
			$this->data = new stdClass();
			foreach ($_POST as $k => $v) {
				$this->data->$k = $v;
			}
		}
		
		
	}
}



