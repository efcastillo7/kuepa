/**
 * modalEffects.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */

// $(document).ready(function(){
// 	triggerModalSuccess({id: "modal-success", title: "Ha enviado su nota", text: "probando 123", effect: "md-effect-2"});
// });

function triggerModalSuccess(data){

	//redo
	el = $("#"+data.id);
	$("#title", el).html(data.title);
	$("#text", el).html(data.text);

	el.addClass("md-show");
	el.addClass(data.effect);
	
	// function removeModalHandler() {
	// 	removeModal( classie.has( el, 'md-setperspective' ) ); 
	// }

	// function removeModal( hasPerspective ) {
	// 	classie.remove( modal, 'md-show' );

	// 	if( hasPerspective ) {
	// 		classie.remove( document.documentElement, 'md-perspective' );
	// 	}
	// }

	var overlay = $('.md-overlay');

	// if( classie.has( el, 'md-setperspective' ) ) {
	// 	setTimeout( function() {
	// 		classie.add( document.documentElement, 'md-perspective' );
	// 	}, 25 );
	// }

	$('.md-close',el).click(function(e){
		console.log("DSAdadas");
		e.stopPropagation();
		el.removeClass('md-show');
	});

}