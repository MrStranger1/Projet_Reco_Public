<?php 
/**
* Class général pour tous application
*/
namespace Strange\libs\classes;

class App
{
	
	public function arrayToObject($array){
	  	if(is_array($array)){
	    	foreach($array as &$item){
	      		$item = arrayToObject($item);
	    	}
	    return (object)$array;
	   }
	   return $array;
	}
}


