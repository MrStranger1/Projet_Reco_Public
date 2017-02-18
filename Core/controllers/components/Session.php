<?php 
/**
* Class Session:: sert, à gérer les sessions
*/
class Session
{

	function __construct()
	{
		if(session_start() === false){
			session_start();
		}
	}

	public function add($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function delete($key)
	{
		if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
		}
	}
	public function getKey($key =null)
	{
		if ($key) {
			if(isset($_SESSION[$key])){
				return $_SESSION[$key];
			}else{
				return false;
			}
		} else {
			return $_SESSION;
		}
	}

	public function setFlash($message, $type)
	{
		$_SESSION['flash']['message'] = $message;
		$_SESSION['flash']['type'] = $type;
	}

	public function flash()
	{
		if(isset($_SESSION['flash'])):?>
			<div class="alert <?php echo $_SESSION['flash']['type']  ?>">
				<?php echo $_SESSION['flash']['message'] ?>
			</div>
		<?php unset($_SESSION['flash']);
		endif;
	}

}

