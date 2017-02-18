<?php 
/**
* 
*/
class Auth
{
	private $db;
	private $session;
	private $configs;

	function __construct($config)
	{
		$this->db 		= $config['db'];	
		$this->session 	= $config['session'];	
		$this->configs	= $config['configs'];
		$this->url 		= $config['url'];
	}

/**
 * savoir si l'utilisateur est connecter
 * @return boolean [retourne ses informations]
 */
	public function isLogged()
	{	
		return $this->session->getkey('Auth');
	}

	public function register($key = null, $value)
	{
		return $this->session->add($key, $value);
	}

	public function getToken($lenght)
	{
		$alphabet = '7894561230azertyuiopqsdfghjklmwxcvbnNBVCXWMLKJHGFDSQPOIUYTREZA';
		$token = substr(str_shuffle(str_repeat($alphabet, $lenght)), 0, $lenght);
		return $token;
	}

/**
 * se connecter
 * @param  string $username identifiant de connection
 * @param  strin $password mot de passe
 * @return boolean           stocke en session et retourne ses informations
 */
	public function login($username = null , $password = null)
	{

		$user_name = isset($username) ? $username : $_POST['username'];
		$user_pass = isset($password) ? $password : $_POST['password'];

		$user = $this->db->findFirst(array('conditions'=> array('username='=>$user_name)));
		var_dump($user);
		if ($user) {
			if($user->password === $this->password($user_pass)){
				unset($user->password);
				$user->url = $this->url;
				$this->session->add('Auth', $user);
				return true;
			}
		}
		return false;
	}

/**
 * deconnecter l'utilisateur
 * @return null supprime sa session et le redirige sur la page de connection
 */
	public function logout()
	{
		$this->session->delete('Auth');
		Router::redirect(['action'=>'login']);
	}

/**
 * hasher le mot de passe
 * @param  string $password mot de passe à hacher
 * @return string           retourne le hash du mot de passe
 */
	public function password($password)
	{
		return sha1($password);
	}

}


