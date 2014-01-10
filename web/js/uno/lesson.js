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
                            $("#notes_list").prepend(data.template);
                        }
                        
                        container.val('');

                        if (edit_note_id != null && edit_note_id != "")
                            $(".li-note-" + edit_note_id + ".edit-delete-tag").remove();
                    } else {
                        alert('error al enviar el comentario');
                    }

                }
            })
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
                    $(".li-note-" + note_id).remove();
                } else {
                    alert('error al eliminar el comentario');
                }

            }
        });
    });

    $("body").delegate(".edit-note-link", "click", function(e) {
        var note_id = $(this).attr("target");
        var edit_input = $("#edit-note-input-" + note_id);
        var span_note = $("#span-note-" + note_id)

        if (edit_input.is(":visible")) {
            //cancelo el edit
            $("#edit-note-link-" + note_id).html("Editar");
        } else {
            //edit
            $("#edit-note-link-" + note_id).html("Cancelar");
        }

        $(".li-note-" + note_id).addClass("edit-delete-tag");

        edit_input.toggle();
        span_note.toggle();
    });

    $( "#tabs" ).tabs();

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
        lpService.add({
            course_id: course_id, lesson_id: lesson_id, chapter_id: chapter_id,
            onSuccess: function(item){
                addItemToPath(item);
            }
        });
    });
});