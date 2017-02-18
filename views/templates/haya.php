<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="webroot/Font/images/fav.ico">
	<title>Ma HAYA</title>
	<?php $this->Html->cssDefault(['Grille','Blocks', 'Show','Inputs', 'Modal']); ?>
	<?php $this->Html->css(['menu','header','content', 'modal', 'pieces']); ?>
</head>
<body>

<div class="modal"></div>

<div class="contenu">
	
	<span class="fermer">X</span>
	<form method="post" accept-charset="utf-8" class="form-input" id="addEvent">
		<h4 class="title">Ajouter un évenement à cette date</h4>
		<input type="text" name="date_debut" placeholder="Date de début">
		<input type="text" name="date_fin" placeholder="Date de fin">
		<input type="text" name="name_event" id="name_event" placeholder="Nom de mon évenement">
		<textarea name="desc_event" id="desc_event" placeholder="Description" class="box"></textarea>
		<input type="submit" name="add" id="addBtn" value="+" class="btn"><br><br><br><br>
		<div class="msg-success"></div>
	</form>
</div>

	<div id="header" class="col-12">
		<div class="col-2" id="haya">
			<?php echo Config::$IA['IA_name']; ?>
		</div>
	</div>

		<div id="menu" class="col-2">
		<h5>Bonjour <?php echo Config::$IA['You_name'];?></h5>
			<ul>
				<li id="home"><a href="Haya-accueil" title="">Acceuil</a></li>
				<li id="moi"><a href="Haya-moi" title="">Moi</a></li>
				<li id="alarm"><a href="Haya-alarms" title="">Alarms</a></li>
				<li id="piece"><a href="Haya-pieces" title="">Mes pièces</a></li>
				<li id="param"><a href="Haya-params" title="">Paramètres</a></li>	
			</ul>	
		</div>

		<!-- Début content -->
		<div class="content">
				<?php echo $content_for_layout; ?>
		</div>
		<!-- Fin content -->

	<?php $this->Html->scriptDefault(['jquery','modal']); ?>
	<?php $this->Html->script(['calendrier', 'lights', 'socket','commande']); ?>
</body>
</html>