<?php 
/**
* Class qui gere les fichiers
*/
namespace Strange\libs\classes;

class Files
{
	
	private $_file;
	function __construct($file)
	{
		if(is_file($file)){
			$this->_file = $file;
		}
	}

/**
 * [read lire un fichier]
 * @return [string] [retourne le texte du fichier]
 */
	public function read()
	{
		if(!file_exists($this->_file)){
			return false;
		}
		return file_get_contents($this->_file);	
		//return readfile($this->_file);
	}


/**
 * [write écrire dans un fichier]
 * @param  [string] $data   [données a ecrire dans le fichier]
 * @param  [bool] $append [écrire a la suite]                              
 * @return [string]    [retourne true]                                                        
 */
	public function write($data, $append = null)
	{
		$write;
		if(isset($append) && $append === true){
				$write = file_put_contents($this->_file,  $data, FILE_APPEND);
			}else{
				$write = file_put_contents($this->_file, $data);
		}
		return $write;
	}
}

 ?>