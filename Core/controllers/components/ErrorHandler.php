<?php 
/**
* 
*/
class ErrorHandler
{
	public $errors = [];
	
	public function addError($error, $key = null)
	{
		if ($key) {
			$this->errors[$key][] = $error;
		} else {
			$this->errors[$key] = $error;
		}
		
	}

	public function hasErrors()
	{
		return count($this->all()) ? true : false;
	}

	public function all($key = null)
	{
		return isset($this->errors[$key]) ? $this->errors[$key] : $this->errors;
	}
	public function first($key)
	{
		return isset($this->all()[$key][0]) ? $this->all()[$key][0] : '';
	}
	public function errors()
	{
		$this->errors = array();
		return $this->errors;
	}
}