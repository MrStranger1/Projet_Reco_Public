<?php 
require '../../Config/Config.php';
require '../../Core/models/Models.php';
$db  = new Models();
$req = $db->getTable('pieces');
if (isset($_POST['etat_lumiere'])) {
	$etat_lumiere = $_POST['etat_lumiere'];
	$num_piece	  = $_POST['num_piece'] +1;
	$rep		  = $req->update(['id_piece'=>$num_piece], ['stat_piece'=> $etat_lumiere]);
	echo 'num piece : ' .$num_piece. ', état : ' .$etat_lumiere; 
}
?>