<?php 
/**
* Fichier de configuration
* permet la configuration de l'app
*/
class Config
{
	//ne pas toucher, sauf si expert
	public static $config   = [
        'debug'         => 0,
    ];

     //Informations de connection la base de donnée, à modifier
	public static $database = [
		'host' 		    => 'localhost',
        'name'          => 'haya',
		'password'	    => '',
		'user'	        => 'root',
    ];

    //ne pas toucher, sauf si expert
    public static $webroot  = [
    	'cssDefault'   => './webroot/Css/Default/',
    	'css'		   => './webroot/Css/',
    	'jsDefault'    => './webroot/Js/Default/',
    	'js'		   => './webroot/Js/',
    	'images'	   => './webroot/Font/images/'
    ];

    //ne pas toucher, sauf si expert
    public static $uploader = [
        'dossierDest' => './../../Forlders/',
        'fileSize'    => 1000000000,
    ];

    //Informations sur nom IA, nom Vous, à modifier
    public static $IA = [
        'IA_name'       => 'Haya',
        'You_name'      => 'mec'
    ];

    //Informations sur la base de donnée, à modifier
    public $fields = [
        'Pieces'    => [
            'piece_id'      => 'id_piece',
            'piece_name'    => 'name_piece',
            'piece_stat'    => 'stat_piece',
            'piece_code'    => 'code'
        ],
        'Events'    => [
            'event_name'    => 'name_event',
            'event_desc'    => 'desc_event',
            'event_date'    => 'date_event',
        ]
    ];
    
    //villes méteo, à modifier
    public static $region_metheo = "villeneuve-les-avignon";
    public static $region_default_metheo = "Paris";

/**
 * [write ecrire des cles de config]
 * @param  [string|array] $key   [cle a ecrire ou tableau]
 * @param  [string] $value [valeur associer a la cle]
 * @return [type]        [description]
 */
    // public static function write($key, $value = null)
    // {
    //     if (is_array($key)) {
    //         foreach ($key as $k => $v) {
    //             self::$config[$k] = $v;
    //         }
    //     } elseif (is_array($value)) {

    //         $array = array($key => $value);
    //         foreach ($array as $name => $v) {
    //             self::$config[$name] =  $v;
    //         }    
    //     }else{
    //         self::$config[$key] =$value;
    //     }
              
    // }

    // public  function read($key = null)
    // {
    //    if ($key) {
    //        return isset($this->$Fields[$key]) ? $this->$Fields[$key] : null;
    //    }
    //    return self::$pieces;
       
    // }

    /**
 * prendre une clé dans un tableau
 * @param  array  $indexes tableau d'inexs a transmettre
 * @param  string|array $value   valeur a transmettre
 * @return fct          retourne la fonction ou le tableau
 */
    private function getValue(array $indexes, $value)
    {
        $key = array_shift($indexes);
        if (empty($indexes)) {
            if (!array_key_exists($key, $value)) {
                return null;
            }
            if (is_array($value[$key])) {
                return new Collection($value[$key]);
            }else{
                return $value[$key];    
            }
        }else{
            return $this->getValue($indexes, $value[$key]); 
        }
    }

    public function get($key = null)
    {
        if (is_null($key)) {
          return $this->fields;
        }else{
            $index = explode('.', $key);
            return $this->getValue($index, $this->fields);
        }
    }
}


