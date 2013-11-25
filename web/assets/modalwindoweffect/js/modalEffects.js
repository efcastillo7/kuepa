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

$(document).ready(function(){
	// triggerModalSuccess({id: "modal-success", title: "Ha enviado su nota", text: "probando 123", effect: "md-effect-17"});
	// triggerModalSuccess({id: "modal-form", title: "Ha enviado su nota", text: "probando 123", effect: "md-effect-17"});
});

function triggerModalSuccess(data){

	//redo
	el = $("#"+data.id);
	$("#title", el).html(data.title);
	$("#text", el).html(data.text);
	el.show();

	el.addClass("md-show");
	el.addClass(data.effect);

	var overlay = $('.md-overlay');

	$('.md-close',el).click(function(e){
		e.stopPropagation();
		el.removeClass('md-show');
	});

}

function triggerModalExercise(data){
	//redo
	el = $("#"+data.id);
	$("#title", el).html(data.title);
	$("#text", el).html(data.text);
	$("#count_questions", el).html(data.count_questions);
	$("#time", el).html(data.time);
	$("#score", el).html(data.score);
	el.show();

	el.addClass("md-show");
	el.addClass(data.effect);

	var overlay = $('.md-overlay');

	$('.md-close',el).click(function(e){
		e.stopPropagation();
		el.removeClass('md-show');
	});

}