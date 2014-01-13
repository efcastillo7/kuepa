$(document).ready(function(){

  /////////////////////////////////////////////////////////////////////// index.php
  $(".btn-subject").click(function(event){
    event.preventDefault();

    var collapsing = $(this).attr("href");
    if( $(collapsing).hasClass('collapsing') ){
      return;
    }

    var arrow = $(this).find(".arrow");
    $(".arrow").not(arrow).hide();
    arrow.slideToggle(300);
  });

  // index-list.php
  $(".subject-item div").click(function(){
    var collapsing = $(this).data("target");
    if( $(collapsing).hasClass('collapsing') ){
      return;
    }

    var arrow = $(this).find(".ico-arrow-right");
    var collapsed = $(this).find(".to-collapse");

    if( arrow.hasClass("active") && !collapsed.hasClass("collapsed") ){
      $(this).find(".ico-arrow-right").removeClass("active");
    }else{
      $(this).find(".ico-arrow-right").addClass("active");
    }

  });

  /////////////////////////////////////////////////////////////////////// end index.php


  /////////////////////////////////////////////////////////////////////// mensajes.php
  $(".input-send-message").on("focus",function(){
    $(".ico-message-hover").css("opacity","1");
  });
  $(".input-send-message").on("blur",function(){
    $(".ico-message-hover").css("opacity","0");
  });

  $('.cont-inboxes').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}); //inicializa el scroll de los inbox (barra izquierda)
  $(".cont-add-users").perfectScrollbar({wheelSpeed:30,wheelPropagation:false});
  $(".cont-chat-users").perfectScrollbar({wheelSpeed:30,wheelPropagation:false,suppressScrollX:true});

  //carga chat1.php al cargar la pagina
  $(".loading").fadeIn(); //muestra el mensaje Cargando...
  $(".load-data").load("chat1.php",function(){ //carga los mensajes via AJAX
    $('.scroll').scrollTop(1000).perfectScrollbar({wheelSpeed:30,wheelPropagation:true,suppressScrollX:true}); //inicializa el scroll
    $(".loading").fadeOut(200);
  });

  //Agregar Usuario
  $(".a-friend").click(function(){
    if( $(".add-users").css("display") == "block" ){
      $(".add-users").slideUp(200);
    }else{
      $(".add-users").slideDown(200);
    }
  });


  $('.dropdown-add-user').click(function(e) {
    e.stopPropagation(); //evita que se cierre la ventana de Agregar contactos
  });


$("a.inbox").click(function(event){

  // Agrega la clase .active al box de mensajes
  $(this).addClass("active");
  $(".inbox").not($(this)).removeClass("active");

  $(".loading").fadeIn();
  var chat = $(this).data("chat");

  $(".load-data").load(chat+".php",function(){
    $('.cont-scroll').perfectScrollbar({wheelSpeed:30,wheelPropagation:true}).scrollTop(1000);
    $(".loading").fadeOut(200);
    $('.cont-scroll').hide().fadeIn();//anima la ventana de mensajes
  });

});
  /////////////////////////////////////////////////////////////////////// end mensajes.php


  /////////////////////////////////////////////////////////////////////// unit_list.php
  /*$(".panel-heading").mouseenter(function(){
    $(this ".tool").tooltip('show');
  });
  $(".panel-heading").mouseleave(function(){
    $(".tool").tooltip('hide');
  });*/
  /////////////////////////////////////////////////////////////////////// end unit_list.php


  /////////////////////////////////////////////////////////////////////// nuevo_evento.php

  var d = new Date();
  var date = d.getDate()+"/"+(d.getMonth() + 1)+"/"+d.getFullYear();
  $(".datepicker").attr("placeholder",date);

  $( "#date-from, #date-to" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true
  });


  $(".btn-close").click(function(event){
    event.preventDefault();
    $(this).parent().slideUp(100);
  });

  $(".hour").keypress(function(){
    validate();
  });

  function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\:/;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }

/////////////////////////////////////////////////////////////////////// end nuevo_evento.php



/////////////////////////////////////////////////////////////////////// calendario.php
  $(function() {
    $( "#mini-calendar" ).datepicker();
  });

  $(".toggle").click(function(){
    var rel = $(this).attr("rel");
    $(".cont-"+rel).slideToggle();

    var arrow = $(this).find(".ico-arrow-list");

    if( $(arrow).hasClass("active") ){
      $(arrow).removeClass("active");
    }else{
      $(arrow).addClass("active");
    }

  });
/////////////////////////////////////////////////////////////////////// end calendario.php
});