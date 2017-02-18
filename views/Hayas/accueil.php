<div class="col-8 com" id="events">
<?php 
		$conf = new Config();
		$ev_name = $conf->get('Events.event_name');
		$ev_desc = $conf->get('Events.event_desc');
		$ev_date = $conf->get('Events.event_date');
		?>	
		<span class="col-12">Maintenant <?php echo date('d M. Y') ?></span><br>
		<?php if (empty($eventsNow)): ?>
				<div class="alert info">Vous n'avez aucun évenement aujourd'hui</div>
			<?php else: ?>	
		<ul>
		
			<?php foreach ($eventsNow as $event): ?>
					<li>
						<div class="algn">
							<span class="event_title"><?php echo ucfirst($event->$ev_name); ?></span>
							<span class="wtime">dans 5 minutes</span>	
						</div>
						<div class="event_desc"><?php echo ucfirst($event->$ev_desc);?></div>
					</li>
			<?php endforeach?>

		</ul>
		<?php endif ?>
		<span>Evenement à venir</span>
		<?php if (empty($eventsAfter)): ?>
				<div class="alert info">Vous n'avez aucun évenement à venir</div>
			<?php else: ?>	
		<ul>
			<?php foreach ((object) $eventsAfter as $event): ?>
					<li>
						<div class="algn">
							<span class="event_title"><?php echo ucfirst($event->$ev_name); ?></span>
							<span class="wtime"><?php echo $event->$ev_date; ?></span>	
						</div>
						<div class="event_desc"><?php echo ucfirst($event->$ev_desc); ?></div>
					</li>
			<?php endforeach?>
		</ul>
		<?php endif ?><br>
	</div>
	<div class="col-1"> </div>
	<div class="col-3 com" id="meteo">
	<!-- Début fenetre pour afficher la méteo, à modifier en renseignant ta ville-->
		<div style="width:100%;height:184px;color:#000;border:none;">
			<iframe height="184" frameborder="0" width="100%" scrolling="no" src="http://www.prevision-meteo.ch/services/html/<?php echo !empty(Config::$region_metheo) ? Config::$region_metheo : Config::$region_default_metheo; ?>/square" allowtransparency="true">
			</iframe>
		</div>
	<!-- Fin fenetre pour afficher la méteo -->
	</div>

	<div class="col-6 com" id="calendar">
		<?php $this->Calendar->jourSemaine(); ?>
	</div>

	<div class="col-6 com" id="calendars">
		Mon sommeil
	</div>