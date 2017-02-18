var Validator = {
/**
 * [getInput vérifier un champ : vide, longueur]
 * @param  {[type]} id [description]
 * @return {[bool]}    [retourne vrai ou faux]
 */
	getInput : function(id){
		if($.trim($('#'+id).val()) == ''){
			$('#'+id).attr('placeholder', 'Veuillez me remplir');
			$('#help-'+id).fadeIn('fast').css('color', '#8B0000').html('Veuillez remplir ce champ');
			return false;
		}else if($.trim($('#'+id).val().length) <= 2){
			$('#'+id).attr('placeholder', 'Veuillez mettre plus de 2 caractère');
			$('#help-'+id).fadeIn('fast').css('color', '#8B0000').html('C \'est trop court, veuillez mettre plus de 2 caractères');
			return false;				
		}else{
			$('#help-'+id).fadeOut('fast');
			return true;
		}
	},

/**
 * [passwordStrong vérifier si un champ correspond au mot de passe fort]
 * @param  {[type]} idpwd [champ mdp a vérifier]
 * @return {[bool]}       [retourne vrai ou faux]
 */
	passwordStrong : function(idpwd) {
		var mdp = $.trim($('#'+idpwd).val());
		if (this.getInput(idpwd)) {
			//if (mdp == '') {
				if(mdp.length >= 8 ){
						if (mdp.match(/[a-z]/)) {
									if (mdp.match(/[A-Z]+/)) {
											if(mdp.match(/[0-9]+/)){
													if (mdp.match(/[@!?/\\$*=+%µ£ù§#.,;_-`~&\':()[\]\|¤°{}ç<>]+/)) {
														$('#help-'+idpwd).fadeIn('fast').css('color', 'green').html('Le mot de passe est correct');
														return true;
													} else {
														$('#'+idpwd).attr('placeholder', 'Je dois contenir au moins 1 caractère spécial');
														$('#help-'+idpwd).fadeIn('fast').css('color', '#8B0000').html('Ce champ doit contenir au moins 1 caractère spécial (@!?/\\$*=+%µ£ù§#.,;_-`~&\':()[\]\|¤°{}ç<>)');
														return false;
													}
											}else{
												$('#'+idpwd).attr('placeholder', 'Je dois contenir au moins 1 chiffre');
												$('#help-'+idpwd).fadeIn('fast').css('color', '#8B0000').html('Le mot de passe doit contenir au moins 1 chiffre');
												return false;
											}
									} else {
										$('#'+idpwd).attr('placeholder', 'Je dois contenira u moins 1 caractère majuscule');
										$('#help-'+idpwd).fadeIn('fast').css('color', '#8B0000').html('Le mot de passe doit contenir au moins 1 caractère majuscule');
										return false;
									}
						} else {
							$('#'+idpwd).attr('placeholder', 'Je dois contenir des caractères minuscules');
							$('#help-'+idpwd).fadeIn('fast').css('color', '#8B0000').html('Le mot de passe doit contenir des caractères minuscules');
							return false;
						}
					
				}else{
				 	$('#'+idpwd).attr('placeholder', 'Je dois contenir au moins 8 caractères');
					$('#help-'+idpwd).fadeIn('fast').css('color', '#8B0000').html('Le mot de passe doit contenir au moins 8 caractères');
				 	return false;
				}
		}	 
	},

/**
 * [getEmail vérifier si champ correspond au format email]
 * @param  {[type]} id_email [champ a vérifier]
 * @return {[bool]}          [retourne vrai ou faux]
 */
	getEmail : function(id_email){

	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,4}$', 'i');
	var mail = $.trim($("#"+id_email).val());

		if(this.getInput(id_email)){

		    if(reg.test(mail)){
				return true;
		      }else{
		      	$('#'+id_email).attr('placeholder', 'Veuiller mettre un format d\'adresse email correct');
				$('#help-'+id_email).fadeIn('fast').css('color', '#8B0000').html('Veuiller mettre un format d\'adresse email correct');
				return false;
		      }
		}

	},

/**
 * [equalpwd vérifier si 2 champs mot de passe correspondent]
 * @param  {[string]} first_id  [premier champ]
 * @param  {[string]} second_id [deuxieme champ]
 * @return {[boolen]}           [retourne vrai ou faux]
 */
	equalpwd : function(first_id, second_id){
		if(this.passwordStrong(first_id) === this.passwordStrong(second_id)){
				
			if ($('#'+first_id).val() !== "" && $('#'+second_id).val() !== "") {

				if ($('#'+first_id).val() === $('#'+second_id).val()) {
					return true;
				} else {
					$('#'+first_id+ ', #'+second_id).attr('placeholder', 'Veuiller faire correspondre les 2 mdp');
					$('#help-'+first_id + ',#help-'+second_id).fadeIn('fast').css('color', '#8B0000').html('Faite correspondre les 2 mot de passe');
					return false;
				}

			}

		}
	}

}