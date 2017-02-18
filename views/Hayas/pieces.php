<?php
$conf = new Config();
$pi_id = $conf->get('Pieces.piece_id');
$pi_name = $conf->get('Pieces.piece_name');
$pi_stat = $conf->get('Pieces.piece_stat');
?>
<table id="pieces" class="table">
	<caption id="caption">Gérer les lumières de mes pièces</caption>
	
		<tr id="num">
			<th>N° pièce</th>
			<th>Nom Pièce</th>
			<th>Etat</th>
		</tr>
			<?php foreach ($pieces as $piece): ?>
				<tr>
					<td><?php echo $piece->$pi_id;?></td>
					<td><?php echo ucfirst(utf8_decode($piece->$pi_name)); ?></td>
					<td>
						<input type="submit" name="et2" 
							value="<?php echo ($piece->$pi_stat == 1) ? 'Allumer' : 'Etteint'; ?>" 
							class="stat btn 
						<?php echo ($piece->$pi_stat == 1) ? 'btn-success' : 'btn-danger'; ?>">
					</td>
				</tr>
			<?php endforeach ?>
</table>