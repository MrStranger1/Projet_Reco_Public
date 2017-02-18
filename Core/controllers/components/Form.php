<?php 
/**
* Class Form:: gerer les formulaires
*/
class Form
{
	
	private $_data;
	public $errorHandler;
	public $validator;

	function __construct(array $config)
	{
		$this->_data = $_POST;
		$this->errorHandler = $config['errorHandler'];
		$this->validator = $config['validator'];
	}



/**
 * [getValue description]
 * @param  [type] $index [description]
 * @return [type]        [description]
 */
	private function getValue($index)
	{
		if(is_object($this->_data)){
			return $this->_data->$index;
		}
		return isset($this->_data[$index]) ? $this->_data[$index] : null;

	}
/**
 * [first met la premier lettre en majuscule]
 * @param  [string] $value [valeur a mettre en majuscule]
 * @return [object]        [retourne la 1er lettre en majuscule]
 */
	private function first($value)
	{
		return ucfirst($value);
	}


	public function create($name = null, array $options = null)
	{	
		$type 		 = isset($options['type']) ? $options['type'] : null;
		$actionName  	 = isset($options['action']) ? $options['action'] : $_GET['action'];
		$controllerName  = isset($options['controller']) ? $options['controller'] : $_GET['controller'];
		$method 	 = isset($options['method']) ? '-'.$options['method'].'"' : null;
		$class 		 = isset($options['class']) ? $options['class'] : 'form-input';
		$id 	 	 = isset($options['id']) ? $options['id'] : ucfirst($controllerName.$actionName);
		$name		 = ucfirst($_GET['controller']).ucfirst($_GET['action']).'Form';
		$params 	 = isset($options['params']) ? '-'.$options['params'] : null;

		$action = 'action="'.$controllerName .'-'.$actionName.$params.'"';

		$paramvs = '<form name="'.$name.'" method="post" '.$action.' class="'.$class.'" id="'.$id.'"';

		if ($type === 'file') {
			$paramvs .= 'enctype="multipart/form-data"';
		}
		return $paramvs.'>';
	}

	public function end($value = 'envoyer', array $options = null)
	{
		$class 	 = isset($options['class']) ? $options['class'] : 'btn';
		$name	 = isset($options['name']) ? $options['name'] : $_GET['controller'].ucfirst($_GET['action']);
		$id		 = isset($options['id']) ? 'id="'.$options['id'].'"' : $name;

		$html = '<p><input type="submit"  name='.$name.' class='.$class.' '.$id.' value='.$value.' />';
		$html .= '</p></form>';
		
		return $html;
	}

/**
 * [label création d'un label]
 * @param  [string]  $label  [texte associer au label]
 * @param  [string]  $class  [class associer au label]
 * @param  boolean $muster [oblige vide ou rempli]
 * @return [object]          [retourne l'object label]
 */
	private function label($label, $class ,$muster = true)
	{
		$return;
		if($muster === true){
			$return = '<label for="'.$class.'" class="must"> '.$this->first($label).'</label>';
		}else{
			$return = '<label for="'.$class.'"> '.$this->first($label).'</label>';
		}
		return $return;
	}

/**
 * [input créer un champ]
 * @param  [string] $type  [type de champ]
 * @param  [string] $name  [nom du champ]
 * @param  [string] $value [valeur du champ]
 * @param  [string] $class [class du champ]
 * @return [string]        [retourne le champ] .$this->getValue[$value].
 */
	public function input($label, $type, $name, $value = null, $require = false)
	{
		$errorClass = '';

		if(empty($this->errorHandler->all($name)[0])){
			$errorClass = '';
		}else{
			$errorClass = ' class="form-error"';
		}
		
		
		$goto = "<div$errorClass>";
		$goto .= $this->label($label, $name, $require);
		$goto .= '<input type="'.$type.'" name="'.$name.'" class ="'.$name.' input-error" id = "'.$name.'" value="'.$this->getValue($name).'"> ';	
		foreach ($this->validator->errors()->errors as $key=>$value) {
			if ($key === $name) {
				$errors = $this->errorHandler->all($key);
				foreach ($errors as $errorKey => $error) {
					$goto .= ' <span id="help-'.$name.'" class="errors">'. $error.'</span><br>';
				}
			}
		}
		$goto .= ' </div>';
		return $goto;
	}

/**
 * [textarea créer une texarea]
 * @param  [string] $label [titre du label]
 * @param  [string] $name  [nom du textarea]
 * @param  [string] $class [class du textarea]
 * @return [data string]        [retourne le textarea créer]
 */
	public function textarea($label, $name, $value = null, $muster)
	{
		$errorClass = '';

		if(empty($this->errorHandler->all($name)[0])){
			$errorClass = '';
		}else{
			$errorClass = ' class="form-error"';
		}

		$goto = "<div$errorClass>";
		$goto .= $this->label($label, $name, $muster);
		$goto .= '<textarea name='.$name.' class="box '. $name.'" id="help-'.$name.'" wrap spellcheck>'.$this->getValue($name).'</textarea>';
		foreach ($this->validator->errors()->errors as $key=>$value) {
			if ($key === $name) {
				$errors = $this->errorHandler->all($key);
				foreach ($errors as $errorKey => $error) {
					$goto .= ' <span id="help-'.$name.'" class="errors">'. $error.'</span><br>';
				}
			}
		}
		$goto .= '</div>';
		return $goto;
	}

	public function select($label, $name, $data = [], $muster)
	{
		$goto = $this->label($label, $name, $muster);
		$goto .= '<select name='.$name.' class='.$name.' id=select'.ucfirst($name).'>';
		foreach ($data as $key => $value) {
			$goto .= '<option value='.strtolower($key).'>'.$this->first($value).'</option>';
		}
		$goto .= '</select>';
		return $goto;
	}

}
