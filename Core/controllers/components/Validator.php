<?php 
class Validator{
	
	protected $errorhandler;
	protected $rules = ['required','maxlength','minlength','email', 'password','is_int','alnum','url','equal', 'uniq'];
	private $complex = '$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$';
	private $items;
	private $db;
	private $messages = [
		'required' 	=> 'Veuillez remplir ce champ',
		'maxlength' => 'Ce champ requis :satisfer caractères maximun',
		'minlength' => 'Ce champ requis :satisfer caractères mininum',
		'email' 	=> 'Ce champ ne correspond pas à une adresse email valide',
		'password' 	=> 'Ce champ ne correspond pas à un mot de passe',
		'is_int' 	=> 'Ce champ n\'est pas un un nombre',
		'alnum' 	=> 'Ce champ doit être alphanuméric',
		'url' 		=> 'Ce champ ne correspond pas à une url valide',
		'equal' 	=> 'Les deux mot de passe doivent correspondres',
		'uniq'		=> 'Cette :field existe déjà',
	];

	function __construct(ErrorHandler $errorhandler, Models $db)
	{
		$this->errorhandler = $errorhandler;
		$this->db 			= $db;
	}


/**
 * [check test si les champs respect toutes les regles]
 * @param  array $items tableau des champs
 * @param  array $rules regles que doivent respecter les champs
 * @return object        retourne l'object
 */
	public function check($items, $rules)
	{
		$this->items = $items;
		foreach ($items as $item => $value) {
			if (in_array($item, array_keys($rules))) {
				$this->validate([
						'field'=>	$item,
						'value'=>	$value,
						'rules'=>	$rules[$item]
								]);
			}
		}
		return $this;
	}

/* retourne toutes les erreurs*/
	public function errors()
	{
		return $this->errorhandler;
	}

/**
 * Valider les erreurs
 * @param  array $item tableau des champs et leurs regles
 * @return object       retourne les erreurs dans lobject
 */
	private function validate($item)
	{
		$field = $item['field'];
		foreach ($item['rules'] as $rule => $satisfer) {
				if (in_array($rule, $this->rules)) {
					if (!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfer])){

						$message = isset($satisfer['message']) ? $satisfer['message'] : $this->messages[$rule];
						
						if (is_array($satisfer)) {
							$replaces = str_replace([':field'], [$field], $message);
						} else {
							$replaces =str_replace([':field', ':satisfer'], [$field, $satisfer], $message);
						}
						$this->errorhandler->addError($replaces, $field);
					}			
				}				
		}
	}

	/* test si ya des erreurs*/
	public function fails()
	{
		return $this->errorhandler->hasErrors();
	}

/*
Toutes les règles
 */

	/* test si champs est rempli*/
	private function required($field, $value, $satisfer)
	{
		$value = trim($value);
		return !empty($value);
	}
	/* test si chamsp contient mininum > satisfer caractere*/
	private function minlength($field, $value, $satisfer)
	{
		$value = trim($value);
		return mb_strlen($value) >= $satisfer;
	}
	/* test si champs contient maximun < satisfezr caractere*/
	private function maxlength($field, $value, $satisfer)
	{
		$value = trim($value);
		return mb_strlen($value) <= $satisfer;
	}
	/* test si champs est une adresse email valide*/
	private function email($field, $value, $satisfer)
	{
		return filter_var($value, FILTER_VALIDATE_EMAIL);
	}
	/* test si champs est un mot de passe complique*/
	private function password($field, $value, $satisfer)
	{
		return preg_match_all($this->complex, $value);
	}
	/* test si champs est nombre*/
	private function is_int($field, $value, $satisfer)
	{
		return filter_var($value, FILTER_VALIDATE_INT);
	}
	/* test si champs est aphanunmérique */
	public function alnum($field, $value, $satisfer)
	{
		return ctype_alnum($value);
	}
	/* test si champs est uen url */
	public function url($field, $value, $satisfer)
	{
		return filter_var($value, FILTER_VALIDATE_URL);
	}
	/* test si deux champs sont egaux {mot de passe}*/
	public function equal($field, $value, $satisfer)
	{
		return $value === $this->items[$satisfer];
	}
	/* test si champs est unique */
	public function uniq($field, $value, $satisfer)
	{
		$table 	= isset($satisfer['table']) ? $satisfer['table'] : null;
		$result = $this->db->row(['value'=>$value, 'table'=>$table, 'key'=>$field]);
		return $result;
	}

}