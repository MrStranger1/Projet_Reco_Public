<?php
/**Class qui chiffre des données
 * 
 */
class Chiffrement {
    private static $cipher  = MCRYPT_RIJNDAEL_128;
    private static $key; 
    private static $mode    = 'cbc';                        
 
/**
 * [setKey choisir la clé de cryptage]
 * @param [string] $_key [phrase clé]
 */
    public static function setKey($_key)
    {
        // self::$key = (object) $_key;
        self::$key = $_key;
        return self::$key;
    }

/**
 * [crypt crypter données]
 * @param  [string] $data [données a chiffrer]
 * @return [data]       [retourn les données chiffrer]
 */
    public static function crypt($data){
        $keyHash = hash('whirlpool', self::$key);
        $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
        $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
 
        $data = mcrypt_encrypt(self::$cipher, $key, $data, self::$mode, $iv);
        return base64_encode($data);
    }
 
/**
 * [decrypt décrpter données]
 * @param  [string] $data [données a déchiffrer]
 * @return [data]       [retourn données déchiffrer]
 */
    public static function decrypt($data){
        $keyHash = hash('whirlpool', self::$key);
        $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
        $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
 
        $data = base64_decode($data);
        $data = mcrypt_decrypt(self::$cipher, $key, $data, self::$mode, $iv);
        return rtrim($data);
    }
}
?>