$(document).ready(function(){

	$('#Userhome').submit(function(e){
		e.preventDefault();

		var validator = Object.create(Validator)
		var notif = validator.getInput('notif');
		if (notif === true) {
			alert('ok')
		} 
		else {
			$('#notif').css({
				border: '2px solid darkred'
			});
		}
	})
});