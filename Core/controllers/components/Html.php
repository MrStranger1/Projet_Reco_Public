<?php 
/**
* Classe Html::premert de créer du contenu html
*/

class Html
{

	public function script(array $file_names){

		foreach ($file_names as $file_name) {
			echo '<script src="'.Config::$webroot['js'].$file_name.'.js" type="text/javascript"></script>';
		}
	}

	public function scriptDefault(array $file_names)
	{
		foreach ($file_names as $file_name) {
			echo '<script src="'.Config::$webroot['jsDefault'].$file_name.'.js" type="text/javascript"></script>';
		}
	}

	public function css(array $file_names)
	{
		foreach ($file_names as $file_name) {
			echo '<link rel="stylesheet" type="text/css" href="'.Config::$webroot['css'].$file_name.'.css">';
		}
	}
	public function cssDefault(array $file_names)
	{
		foreach ($file_names as $file_name) {
			echo '<link rel="stylesheet" type="text/css" href="'.Config::$webroot['cssDefault'].$file_name.'.css">';
		}
	}

	public function img($file_name, array $options = null)
	{
		if(!isset($options)){
			return '<img src="'.Config::$webroot['images'].$file_name.'">';
		}else{
			$options_all ='';
			foreach ($options as $propriete => $valeur) {
				$options_all .= ' '.$propriete . '="'.$valeur.'"';
			}
			echo '<img src="'.Config::$webroot['images'].$file_name.'" '.$options_all.' >';
		}
	}
	
}




