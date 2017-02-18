$(document).ready(function () {
	var etat_lumiere = 0;
	var num_piece = 0;

	$('#pieces .stat').each(function(i, valus){
		$(this).click(function () {
			num_piece = i;

			if ($(this).hasClass('btn-success')) { //lumiere(s) éteintent
				$(this).removeClass('btn-success').addClass('btn-danger').val('Etteint')
				etat_lumiere = 0;
			} else { //lumiere(s) allumer
				$(this).removeClass('btn-danger').addClass('btn-success').val('Allumer');	
				etat_lumiere = 1;
			}
			$.post('./views/Responses/StatLights.php', {num_piece: num_piece, etat_lumiere : etat_lumiere}, function(data, textStatus, xhr) {
				console.log(data)
			});
			
		})
		
	})

})