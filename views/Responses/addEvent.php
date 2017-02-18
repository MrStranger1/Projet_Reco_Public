<?php 
require '../../Config/Config.php';
require '../../Core/models/Models.php';
$db  = new Models();
$insert = $db->getTable('events');
$date = date('Y-m').'-'.$_POST['jour'];

$name = $_POST['name_event'];
$desc = $_POST['desc_event'];

?>
<?php if (!empty($name) && !empty($desc)): ?>

	<?php $insert->save(['name_event'=>$name, 'desc_event' =>$desc,'date_event'=>$date]) ?>
		<div class="alert success">
			Evenement ajouter
		</div>
	<?php else: ?>
		<div class="alert error">
			Il ya eu un souci
		</div>

<?php endif ?>
