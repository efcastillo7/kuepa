function update_resource(values){
  $.ajax({
    url: '/kuepa_api_dev.php/resource/' + resource_id,
    data: {
      content: values.content,
      name: values.title
    },
    dataType: 'json',
    type: 'PUT',
    success: function(data){
      values.success(data);
      $("#title").html(data.name);
      alert('Datos guardados satisfactoriamente');
    },
    error: function(data){
      $("#title").html(values.title);
      alert('Error en la llamada.');
    },
    complete: function(data){
      values.complete(data);

      //buttons
      $("#save_update_resource").addClass('hidden');
      $("#edit_update_resource").removeClass('hidden');
      $("#preliminar_update_resource").addClass('hidden');
      $("#cancel_update_resource").addClass('hidden');
      $("#continue_update_resource").addClass('hidden');
      $("#resource-video-link-container").addClass('hidden');
    }
  });
}

var resource = {title: '', content: ''};

function show_edit_fields(title){
  $("#save_update_resource").removeClass('hidden');
  $("#edit_update_resource").addClass('hidden');
  $("#preliminar_update_resource").removeClass('hidden');
  $("#cancel_update_resource").removeClass('hidden');
  $("#continue_update_resource").addClass('hidden');

  //edit title
  $("#title").html("<input type='text' value='" + title + "'>");

  //edit content
  if($("#resource-content-text").length > 0){
    tinymce_values = {
        mode: "none",
        plugins: [
            "advlist autolink lists link image charmap anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages"
        ],
        relative_urls: false,
        convert_urls: false,
        remove_script_host : false,
        menubar: "edit insert format view table",
        toolbar1: "undo redo | styleselect | bold italic | link image media | code | fullscreen",
        toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        selector: "#resource-content-text"
    };

    tinyMCE.init(tinymce_values);
  }else if($("#resource-video-youtube").length > 0){
    $("#resource-video-link-container").removeClass('hidden');
    var parent = $("#resource-video-youtube").parent();

    //remove
    _V_("resource-video-youtube").dispose();

    parent.append("<div id='resource-video-youtube' class='video-js vjs-default-skin' width='auto' height='500'>");

  }else if($("#resource-video-vimeo").length > 0){
    $("#resource-video-link-container").removeClass('hidden');
    var parent = $("#resource-video-vimeo").parent();

    //remove
    _V_("resource-video-vimeo").dispose();

    parent.append("<div id='resource-video-vimeo' class='video-js vjs-default-skin' width='auto' height='500'>");
  }
}

$(document).ready(function() {
  //preliminar click
  $("#preliminar_update_resource").click(function(){
    if($("#resource-content-text").length > 0){
      //remove tinymce
      var ed = tinyMCE.get('resource-content-text');
      ed.remove();

      //set title
      var title = $("#title input").val().trim();
      $("#title").html(title);
    }else if($("#resource-video-youtube").length > 0){
      var title = $("#title input").val().trim();
      $("#title").html(title);
      $("#resource-video-link-container").addClass('hidden');

      var video = $("#resource-video-link").val();
      videojs('resource-video-youtube', { "techOrder": ["youtube"], "src": video });
    }else if($("#resource-video-vimeo").length > 0){
      var title = $("#title input").val().trim();
      $("#title").html(title);
      $("#resource-video-link-container").addClass('hidden');

      var video = $("#resource-video-link").val();
      videojs('resource-video-vimeo', { "techOrder": ["vimeo"], "src": video });
    }

    $("#save_update_resource").addClass('hidden');
    $("#edit_update_resource").addClass('hidden');
    $("#preliminar_update_resource").addClass('hidden');
    $("#cancel_update_resource").removeClass('hidden');
    $("#continue_update_resource").removeClass('hidden');
    $("#resource-video-link-container").addClass('hidden');
  });


  //cancel edit click
  $("#cancel_update_resource").click(function(){
    //if text
    if($("#resource-content-text").length > 0){
      //remove tinymce
      var ed = tinyMCE.get('resource-content-text');
      if(ed != undefined){
        ed.remove();
      }
      resource.content = $("#resource-content-text").html();
    }else if($("#resource-video-youtube").length > 0){
      //if video
      var parent = $("#resource-video-youtube").parent();
      _V_("resource-video-youtube").dispose();
      parent.append("<div id='resource-video-youtube' class='video-js vjs-default-skin' width='auto' height='500'>");

      videojs('resource-video-youtube', { "techOrder": ["youtube"], "src": resource.content });
    }else if($("#resource-video-vimeo").length > 0){
      var parent = $("#resource-video-vimeo").parent();
      _V_("resource-video-vimeo").dispose();
      parent.append("<div id='resource-video-vimeo' class='video-js vjs-default-skin' width='auto' height='500'>");

      videojs('resource-video-youtube', { "techOrder": ["vimeo"], "src": resource.content });
    }

    //restore title and contnet
    $("#title").html(resource.title);
    $("#resource-content-text").html(resource.content);

    $("#save_update_resource").addClass('hidden');
    $("#edit_update_resource").removeClass('hidden');
    $("#preliminar_update_resource").addClass('hidden');
    $("#continue_update_resource").addClass('hidden');
    $("#cancel_update_resource").addClass('hidden');
    $("#continue_update_resource").addClass('hidden');
    $("#resource-video-link-container").addClass('hidden');
  });

  $("#continue_update_resource").click(function(){
    var title = $("#title").html().trim();
    show_edit_fields(title);
  });

  //edit click
  $("#edit_update_resource").click(function(){
    resource.title = $("#title").html().trim();

    if($("#resource-content-text").length > 0){
      resource.content = $("#resource-content-text").html();
    }else if($("#resource-video-youtube").length > 0){
      resource.content = $("#resource-video-link").val();      
    }else if($("#resource-video-vimeo").length > 0){
      resource.content = $("#resource-video-link").val();
    }

    show_edit_fields(resource.title);
  });

  //save click
  $("#save_update_resource").click(function(){
    var title = $("#title input").val().trim();

    //if is text
    if($("#resource-content-text").length > 0){
      tinyMCE.triggerSave();

      var ed = tinyMCE.get('resource-content-text');
      var content = ed.getContent();

      //set progress state
      ed.setProgressState(1);

      //update resource
      update_resource({
        title: title,
        content: content,
        success: function(data){
          $("#resource-content-text").html(data.ResourceData[0].content);
        },
        complete: function(data){
          ed.setProgressState(0);
          ed.remove();
        }
      });
    }else if($("#resource-video-youtube").length > 0){
      var content = $("#resource-video-link").val();
      var video = resource.content;

      update_resource({
        title: title,
        content: content,
        success: function(data){
          video = data.ResourceData[0].content;
        },
        complete: function(data){
          var parent = $("#resource-video-youtube").parent();
          _V_("resource-video-youtube").dispose();
          parent.append("<div id='resource-video-youtube' class='video-js vjs-default-skin' width='auto' height='500'>");

          videojs('resource-video-youtube', { "techOrder": ["youtube"], "src": video });
        }
      });

    }else if($("#resource-video-vimeo").length > 0){
      var content = $("#resource-video-link").val();
      var video = resource.content;

      update_resource({
        title: title,
        content: content,
        success: function(data){
          video = data.ResourceData[0].content;
        },
        complete: function(data){
          var parent = $("#resource-video-vimeo").parent();
          _V_("resource-video-vimeo").dispose();
          parent.append("<div id='resource-video-vimeo' class='video-js vjs-default-skin' width='auto' height='500'>");

          videojs('resource-video-vimeo', { "techOrder": ["vimeo"], "src": video });
        }
      });
    }
  });



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

    $("body").delegate(".navigation-menu", "click", function(e) {
      e.preventDefault();
      var link = $(this).attr('href'),
        parent = $(this).parents(".menu-container:first"),
        container = $(this).parents(".wrapper-aside-lesson,.wrapper-aside-exercise").first(),
        goto_dir = $(this).hasClass("navigation-menu-in"),
        from = "left",
        to = "right";
      
      $.getJSON($(this).attr('href'), function(response) {
          var content = $(response.template).hide();
          $(".knob", content).knob(knob_values);

          if(goto_dir){
            from = "right"; to = "left";
          }

          parent.prepend(content);
          //remove old
          $(container).hide('slide', {direction: to}, function(){ 
            container.remove(); 
          });
          $(content).show('slide', {direction: from});
      });

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
});