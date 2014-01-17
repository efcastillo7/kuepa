$(document).ready(function() {
    $("body").delegate(".input_add_note", "keyup", function(e) {
        container = $(this);
        if (e.keyCode == 13) {
            e.preventDefault();

            var resource_id = $(this).attr('resource-id');
            var content = $(this).val();
            var edit_note_id = $(this).attr('edit-note-id');
            var privacy = $(this).attr('privacy');
            // Define el selector para depositar el retorno de la nueva nota
            var target =  $(this).attr('target');

            $.ajax('/note/add', {
                data: {resource_id: resource_id, content: content, edit_note_id: edit_note_id, privacy: privacy},
                dataType: 'json',
                type: 'POST',
                success: function(data) {
                    if (data.code === 201) {
                        //new note
                        if ( typeof(target) != "undefined"){
                            $(target).prepend(data.template);
                        } else {
                            $(".notes.private").prepend(data.template);
                        }
                        
                        container.val('');

                        if (edit_note_id != null && edit_note_id != "")
                            $(".li-note-" + edit_note_id + ".edit-delete-tag").remove();
                    } else {
                        alert('error al enviar el comentario');
                    }

                }
            });
        }
    });

    $("body").delegate(".delete-note-link", "click", function(e) {
        var note_id = $(this).attr("target");
        $.ajax('/note/delete', {
            data: {note_id: note_id},
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                if (data.code === 201) {
                    $("#note-" + note_id).remove();
                } else {
                    alert('error al eliminar el comentario');
                }

            }
        });
    });

    $("body").delegate(".edit-note-link", "click", function(e) {
        var note_id = $(this).data("target");

        var edit_input = $("#edit-note-input-" + note_id);
        var span_note = $("#span-note-" + note_id)

        if (edit_input.is(":visible")) {
            //cancelo el edit
            $("#edit-note-link-" + note_id).html("Editar");
        } else {
            //edit
            $("#edit-note-link-" + note_id).html("Cancelar");
        }

        $("#note-" + note_id).addClass("edit-delete-tag");

        edit_input.toggle();
        span_note.toggle();
    });

    // $( "#tabs" ).tabs();

    //log interval
    setInterval(function(){
        $.ajax('/log/resource', {
            data: {resource_id: resource_id, course_id: course_id, lesson_id: lesson_id, chapter_id: chapter_id},
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                // console.log(data);
            }
        });
    }, 26000);
});

$(window).load(function(){
    $("#add_to_learning_path").click(function(){
        //show menu right
        classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );

        lpService.add({
            course_id: course_id, lesson_id: lesson_id, chapter_id: chapter_id,
            onSuccess: function(item){
                addItemToPath(item);
            },
            onError: function(data){
                alert('Ya tiene esa lección');
            }
        });
    });
});

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

/////////////////////////////////////////////////////////////////////// ejercitacion.php
  //arrows
  $(".title-arrow").click(function(){
    var arrow = $(this).find("i");
    var collapsing = $(this).data("target");

    if( $(collapsing).hasClass('collapsing') ){return;}

    if( $(arrow).hasClass("rotate") ){
      $(arrow).removeClass("rotate");
    }else{
      $(arrow).addClass("rotate");
    }
  });

  //orange icon
  $(".section li a").click(function(){
    var collapsing = $(this).data("target");

    if( $(collapsing).hasClass('collapsing') ){
      return;
    }

    var icon = $(this).find(".back-icon");
    var after = $(this).find(".after");
    var before = $(this).find(".before");

    if( $(icon).hasClass("active") ){
      $(icon).removeClass("active");
      $(after).removeClass("active");
      $(before).removeClass("active");
    }else{
      $(icon).addClass("active");
      $(after).addClass("active");
      $(before).addClass("active");
    }
  });

  // scrollspy

  // Cache selectors
  var lastId,
  //topMenu = $("#top-menu"),
      topMenu = $(".questions"),
      topMenuHeight = topMenu.outerHeight()+15,
  // All list items
      menuItems = topMenu.find("a"),
  // Anchors corresponding to menu items
      scrollItems = menuItems.map(function(){
        var item = $($(this).attr("href"));
        if (item.length) { return item; }
      });

  // Bind click handler to menu items
  // so we can get a fancy scroll animation
  menuItems.click(function(e){
    var href = $(this).attr("href"),
        offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight-50;
    $('html, body').stop().animate({
      scrollTop: offsetTop
    }, 300);
    e.preventDefault();
  });

  // Bind to scroll
  $(window).scroll(function(){
    // Get container scroll position
    //var fromTop = $(this).scrollTop()+topMenuHeight;
    var fromTop = $(this).scrollTop()+topMenuHeight+55;

    // Get id of current scroll item
    var cur = scrollItems.map(function(){
      if ($(this).offset().top < fromTop)
        return this;
    });
    // Get the id of the current element
    cur = cur[cur.length-1];
    var id = cur && cur.length ? cur[0].id : "";

    if (lastId !== id) {
      lastId = id;
      // Set/remove active class
      menuItems
          .parent().removeClass("active")
          .end().filter("[href=#"+id+"]").parent().addClass("active");
    }
  });

/////////////////////////////////////////////////////////////////////// end ejercitacion.php

  // aside follow scroll
  $(document).scroll(function () {
    var altura = $("section.container section.breadcrum").height() + $(".header-two-columns").height() + 20;//20 es el padding de scroll1

    if ($(document).scrollTop() > altura) {
      $('.aside-exercise,.aside-lesson').removeClass("relativa").addClass("fija");
    }
    else {
      $('.aside-exercise,.aside-lesson').removeClass("fija").addClass('relativa');
    }
  });

/////////////////////////////////////////////////////////////////////// leccion_recurso.php

  $(function() {

    $(".list-aside-lesson li a").each(function(){
      var text = $(this).text().trim();
      var len = text.length;
      console.log(len);

      if( len > 30 ){
        $(this).html("<span>" + text + "</span>");
        $(this).parent("li").addClass("long");
        $(this).children("span").addClass("long-text");

        var li = $(this).parent(".long");
        var altura = $(li).height();

        $(li).find(".icon").css("top",(altura-44)/2);
        $(li).find(".lp-bar-post").css({
          "height":((altura-30)/2)+1,
          "top":"4px"
        });
        $(li).find(".lp-bar-prev").css({
          "height":((altura-30)/2)+2,
          "bottom":0
        });
      }


    });
  });
/////////////////////////////////////////////////////////////////////// end leccion_recurso.php
});