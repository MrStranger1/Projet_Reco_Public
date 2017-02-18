<?php 
/**
* Class Database : pour manipuler les bases de donnees
*/
class Models
{
	public static $_table = false;	
	private $pdo;
	public $validates = array();

	function __construct($table = null)
	{
		if (isset($table) && self::$_table !== false) {
			self::$_table = $table;
		} else {
			self::$_table = strtolower(get_class($this)) .'s';
		}
	}

	/**
	 * [Connect connection a la base de donnee]
	 */
	public function getPdo()
	{
		if($this->pdo == null){
			$pdo = new PDO('mysql:host='.Config::$database['host'].';dbname='.Config::$database['name'],Config::$database['user'], Config::$database['password']);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		}
		return $this->pdo;
	}

/**
 * [query faire une recherche dans une table]
 * @param  [string] $statement  [la requete]
 * @param  [string] $class_name [la class appele]
 * @return [array]             [retourne les données]
 */
	public function query($statement, $class_name = null)
	{

		$datas = [];
		$req = $this->getPdo()->query($statement);
		if(strpos($statement, 'UPDATE') === 0 ||
		   strpos($statement, 'INSERT') === 0 ||
		   strpos($statement, 'DELETE') === 0
		  )
		{
			return $req;
		}
		if(isset($class_name)){
			$datas = $req->fetchAll(PDO::FETCH_CLASS, $class_name);
		}else{
			$datas = $req->fetchAll(PDO::FETCH_OBJ);
		}
		$req->closeCursor();
		$this->getRequestInfo($req);
		return $datas;
	}


/**
 * [all extraire tous les champs d'une table]
 * @return [array]         [retourne les données]
 */
	public function all()
	{
		$datas = $this->query('SELECT * FROM '.self::$_table);
		return $datas;
	}
/**
 * [getTable description]
 * @param  [type] $table [description]
 * @return [type]        [description]
 */
	public static function getTable($table)
	{
		return new Models(self::$_table = $table);
	}

/**
 * [prepare faire une requete preparer]
 * @param  [string] $statement  [requete]
 * @param  [array] $params     [champs a selectionner]
 * @param  [string] $class_name [class a utilisé]
 * @return [array]             [retourne les données]
 */
	public function prepare($statement, $params, $class_name = null)
	{
		$req = $this->getPdo()->prepare($statement);
		$req->execute($params);
		if(strpos($statement, 'UPDATE') === 0 ||
		   strpos($statement, 'INSERT') === 0 ||
		   strpos($statement, 'DELETE') === 0
		  )
		{
			return $req;
		}
		if ($class_name) {
			$datas = $req->fetchAll(PDO::FETCH_CLASS, $class_name);
		} else {
			$datas = $req->fetchAll(PDO::FETCH_OBJ);
		}
		$this->getRequestInfo($req);
		return $datas;
	}

/**
 * [lastId recupere le dernier id]
 * @return [type] [description] : marche pas
 */
	protected function lastId()
	{
		return $this->getPdo()->lastInsertId();
	}

	/**
 * [update modifier donnees dans une base de données]
 * @param  [array] $id     [champs a modifier]
 * @param  [array] $fields [champs et valeur modifier]
 * @return [boolen]         [retourne reponse Vrai ou Faux]
 */
	public function update(array $id, array $fields)
	{
		$sql_parts_vals = [];
		$attributes = [];

		$where_id 		= implode(' ', array_keys($id));
		$where_value 	= implode(' ', array_values($id));

		foreach ($fields as $key => $value) { // pour parametres : SET
			$sql_parts_vals[] = htmlspecialchars("$key = ?");
			$attributes[] = htmlspecialchars($value);
		}
		
		$attributes[] = $where_value;
		$sql_part = implode(', ', $sql_parts_vals);
		
		return $this->prepare("UPDATE ".self::$_table." SET " .$sql_part. " WHERE ". $where_id . " = ? ", $attributes, false);
	}

/**
 * [delete supprimer des données]
 * @param  [int] $id [identifiant a supprimer]
 * @return [type]     [description]
 */
	public function delete(array $id)
	{
		$where_id 		= implode(' ', array_keys($id));
		$where_value 	= implode(' ', array_values($id));
		$del = $this->prepare('DELETE FROM '.self::$_table.' WHERE '.$where_id.' = ? ', [$where_value]);
		var_dump($del);
		return $del;
	}

/**
 * [row compte le nombre d'enregistrement]
 * @param  array  $req [parametres a passer]
 * @return [type]      [retourne si >0|<0]
 */
	public function row(array $req)
	{
		$key 	= isset($req['key']) ? $req['key'] : 'id';
		$value 	= isset($req['value']) ? $req['value'] : null;
		$table 	= isset($req['table']) ? $req['table'] : self::$_table;
		$req 	= $this->getPdo()->prepare('SELECT * FROM '.$table .' WHERE '.$key.' = ? ');
		$req->execute([$value]);
		$this->getRequestInfo($req);
		return !$req->rowCount();
	}

/**
 * [save inserer des données dans la base]
 * @param  [array] $fields [tableau a tra,nsferfer]
 * @return [null]         [retourne entre]
 */
	public function save($fields)
	{

		if (method_exists($this, 'beforeSave')) {
			$retour = $this->beforeSave($fields);
		}
		
		if (isset($retour) && is_object($retour)) {
			$fields = (array) $retour;
		}
		$ids = [];
		$attribs = [];
		foreach ($fields as $key => $value) {
			$cles[] = $key;
			$valeurs[] = ':'.$key;
		}
		$clesAll = implode(', ', $cles);
		$valeursAll = implode(', ', $valeurs);

		return $this->prepare('INSERT INTO '.self::$_table.' ('.$clesAll.') VALUES('.$valeursAll.')', $fields, false);
	}

    
/**
 * [find rechercher dans une base de donnée]
 * @param  array|null $sql [tableau des paramètres]
 * @return [array|data]          [retourne les données]
 */
    
	public function find($sql = null)
	{

		$fields = null;
		$resultKeys = [];
		$resultValues = [];

		if($sql === 'all'){
			return $this->all();
		}else{
				//pour les champs
				$req = 'SELECT ';
				if (isset($sql['fields']) ){
					$fields = implode(', ', $sql['fields']);
				} else {
					$fields = '* ';
				}
			
				$req .= htmlspecialchars(trim($fields)). ' FROM ' .self::$_table;

				//pour les jointures de table
				if (isset($sql['join'])) {
					if(isset($sql['join']['table']) && isset($sql['join']['on']) && isset($sql['join']['mode'])){
						$req .= ' '.$sql['join']['mode'].' '.$sql['join']['table']. ' ON '.$sql['join']['on'];
					}else{
						$req .='';
					}
				} else {
					$req .='';
				}
				
				//pour les conditions
				if(isset($sql['conditions'])){
					foreach ($sql['conditions'] as $kId => $id) {
						$resultKeys[] = $kId .' ?';
						$resultValues[] = htmlspecialchars(trim($id));
					}	
					$req .= ' WHERE ';
				}else{
					$req .= '';
				}
				$AllKeys = implode(' AND ', $resultKeys);
				$req .= htmlspecialchars(trim($AllKeys));

				//pour l'ordre
				if (isset($sql['order'])) {
					$req .=  ' ORDER BY ' .$sql['order'];
				} else {
					$req .= '';
				}

				//pour la limit
				if (isset($sql['limit'])) {
					$req .=  ' LIMIT ' .$sql['limit'];
				} else {
					$req .= '';
				}
				$data = $this->prepare($req, $resultValues, false);

				if (method_exists($this, 'afterFind')) {
						$this->afterFind($data);
				}
				return $data;
		}	
	}

/**
 * [findFirst rechercher un seul]
 * @param  [array] $req [conditions|champs..]
 * @return [array]      [retourn le resultat]
 */
	public function findFirst($req = null)
	{
		return current($this->find($req));
	}


/**
 * [validate valider les champs]
 * @return [boolean] [retourne si erreur:true|false]
 */
	public function validate()
	{
		if(!empty($this->validates) && !empty($_POST)){
			
			$this->Form->validator->check($_POST, $this->validates);
			if ($this->Form->validator->fails()) { // si y aune erreur
				return false;
			}else{
				return true;
			}
		}
	}

	public function getRequestInfo($request)
	{
		if (Config::$config['debug'] == 1) {
			echo '<div class="db"><p>';
				var_dump($request);
			echo '</div>';
		}
	}

}