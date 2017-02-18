<?php 
/**
* 	class Security::permet de chiffrer les donnees
*/
class Security
{
	
	public static function encrypt($data)
	{
		return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::getKey(), $data, MCRYPT_MODE_ECB)));
	}

	public static function decrypt($data)
	{
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::getKey(),base64_decode($data), MCRYPT_MODE_ECB));
	}

	public static function getKey()
	{
		return hash('haval128,4', "Ah pourquoi Pépita sans répit m'épies-tu, Dans le puits Pépita pourquoi te tapis-tu Tu m'épies sans pitié, c'est piteux de m'épier De m'épier Pépita, pourrais-tu te passer ? Quand un cordier cordant doit accorder sa corde,  Que c'est crevant de voir crever une crevette sur la cravate d'un homme crevé dans une crevasse. Le général Joffrin étonnamment monotone et lasse montre à nos gens l'heure au trou");
	}

	public static function Hash($data)
	{
		return hash('Whirlpool',$data);
	}
}

