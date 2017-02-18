$(document).ready(function(){
	var jour = new Date();
	var jour = jour.getDate();
	var eventDay = '';
	$('.msg-success').html('');
	
// Met jour actuelle
	$('#caltable td.click').each(function(index, val){
		
		$(this).click(function(){
			eventDay = val.innerText;	
		});
		if (jour == val.innerText) {
			$(this).addClass('current');
		}
		if (jour > val.innerText ) {
			$(this).addClass('past');
			$(this).removeClass('click')
		} else {
			$(this).css('cursor','pointer');
		}

	});
	$('#addEvent').submit(function(){
		var name_event = $('#name_event').val();
		var desc_event = $('#desc_event').val();
		$.post('./views/Responses/addEvent.php', {jour : eventDay, desc_event : desc_event, name_event : name_event }, function(data){
			$('.msg-success').append(data);
			$('#name_event').val('');
			$('#desc_event').val('');
		});
		$('.msg-success').html('');
		return false;
	});
//appelle fenetre modal pour ajouter un évenement	
	var modal = Object.create(Modal);
		modal.active('click', 'modal', 'contenu', 'fermer');

});