/**
 * [Modal créer une fenetre modale]
 * @type {Object}
 */
var Modal = {
	/**
	 * [active activé la fenetre modale]
	 * @param  {[object]} click   [nom bouton d'activation]
	 * @param  {[string]} bgr     [nom selectionné fond à mettre]
	 * @param  {[string]} f_modal [nom fenetre modale]
	 * @param  {[string]} fermer  [nom btn fermer]
	 * @return {[bool]}         [return rien]
	 */
	active : function(click, bgr, f_modal, fermer){

			$('.'+click).click(function(){
				$('.'+bgr+',.'+f_modal).css('display', 'block');
				$('.'+bgr).animate({'opacity': '.8'}, 400);
				$('.'+f_modal).animate({'opacity': '1', 'display' : 'block','z-index': '10'}, 400);
				return false;
			});

			$('.'+fermer).click(function(){
			$('.'+bgr+', .'+f_modal).animate({'opacity': '0'}, 400, function(){
				$('.'+bgr+', .'+f_modal).css('display', 'none');
			});
		});
	}
}