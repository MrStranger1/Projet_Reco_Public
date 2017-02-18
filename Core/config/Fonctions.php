<?php 
function debug($var)
{
	echo '<style type="text/css" media="screen">';
	echo '.test {background-color:whitesmoke; width:auto; border-radius:5px;padding:8px;border:1px solid black;font-size:20px;color:darkred;font-family:sans-serif}';
	echo "</style>";
	echo "<pre>";
	$traces = debug_backtrace();
	var_dump($var);
	echo "<div class='test'>";
	echo 'Fichier '.$traces[0]['file'];
	echo '<br>Ligne : '.$traces[0]['line'];
	echo "</div></pre>";
}
function dd($var)
{
	debug($var);
	die();
}
?>