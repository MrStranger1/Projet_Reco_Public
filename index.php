<?php
require 'core/config/Fonctions.php';
require 'config/Config.php';
require 'core/models/Models.php';
require 'models/AppModels.php';
require 'core/config/Request.php';
require 'core/controllers/Controllers.php';
require 'controllers/AppControllers.php';
require 'core/config/Routeur.php';
require 'core/config/Dispatcher.php';

if(!empty($_GET) && isset($_GET)){
	$dispacher = new Dispatcher();
}else{
	header('location:Haya-accueil');
}
?>