<?php 
/**
* Class qui gere les upload des fichiers (img, mp3)
*/

class Uploader
{
	
	private $erreur = [];
	private $erreurs; // inutile
	private $dossier_dest;
	private $_taille_maxi = 14579; //0500000809;
	private $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.JPEG', '.PNG', '.GIJ', '.JPG');

/**
 * [setExtensions_allow listes des extensions autorisées]
 * @param array $array [tableaux des extensions]
 */
	public function setExtensions_allow($array = [])
	{
		$this->extensions = $array;
	}

/**
 * [get_extensions donnes les extensions]
 * @return [type] [retourne le tableau des extensions]
 */
	public function get_extensions()
	{
		return $this->extensions;
	}

/**
 * [config configure dossier destination et taille maxi du fichier]
 * @param  [string] $dossier     [dossier de destination du fichier]
 * @param  [string] $taille_maxi [taille maximun du fichier]
 * @return [void]              [retourne rien]
 */
	public function config($dossier, $taille_maxi)
	{
		$this->dossier_dest = $dossier;
		$this->_taille_maxi = $taille_maxi;
	}

	public function getDestinationForlder()
	{
		return $this->dossier_dest;
	}

/**
 * [move fonction qui uploader le fichier]
 * @param  [string] $index [champ du fichier]
 * @return [bool]        [retourne fichier bien uploader]
 */
	public function move($index)
	{
	 
		try {

			$taille = filesize($_FILES[$index]['tmp_name']); // taille du fichier

			$fichier = basename($_FILES[$index]['name']);
			$this->dossier_dest = $this->dossier_dest.'/'.$fichier;
			$extension = strrchr($_FILES[$index]['name'], '.'); 

				if(in_array($extension, $this->extensions))
				{
						if($taille <= $this->_taille_maxi)
						{
								if(move_uploaded_file($_FILES[$index]['tmp_name'], $this->dossier_dest)){
									$this->erreur['file_good'] = true;
									$this->erreur['file_name'] = $fichier;
									$this->erreur['file_dest'] = $this->dossier_dest;
								}else {	$this->erreur['false'] = false; }

						}else{	
				     		$this->erreur['gros'] = 'Le fichier est trop gros... ! ';
						}
				
				}else{
				     $this->erreur['allow'] = 'Seul les fichiers de type ' . implode('  , ', $this->get_extensions()).' sont autorisées';
				}
				$this->erreur = (object) $this->erreur;
				return $this->erreur;
		} catch (Exception $e) {
			echo 'Il y a un super gros probleme ' . $e->getMessag();
		}
	}
}	
?>