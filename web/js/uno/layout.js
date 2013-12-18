$(function() {
    $(".knob").knob(knob_values);

    $("body").delegate(".component_edit_link", "click", function(e) {
        var target = $(this).attr("target");
        triggerModalSuccess({id: target, title: "Editar", effect: "md-effect-17"});
    });

    $("a.component_remove_link").click(function(e){
        e.preventDefault();

        var child_id = $(this).attr("child_id");
        var parent_id = $(this).attr("parent_id");

        //todo better !
        var container = $(this).parent();
        if(!container.hasClass("a-son-li")){
            container = container.parent();
        }
        if(!container.hasClass("a-son-li")){
            container = container.parent();
        }
        //end todo better

        container.hide("blind");

        // ajax
        $.ajax('/component/remove', {
            data: {parent_id: parent_id, child_id: child_id},
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                if (data.status === "success") {
                    container.hide("blind");
                    // alert("ok");
                } else {
                    alert("error");
                }
            }
        });

    });

    $("a.component_set_status").click(function(e){
        e.preventDefault();

        var child_id = $(this).attr("child_id");
        var parent_id = $(this).attr("parent_id");
        var obj = $(this);

        // ajax
        $.ajax('/component/setstatus', {
            data: {parent_id: parent_id, child_id: child_id},
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                if (data.status === "success") {
                    obj.toggleClass('btn-success');
                    obj.toggleClass('btn-warning');
                    if(obj.html() == "Activar"){
                        obj.html("Desactivar");
                    }else{
                        obj.html("Activar");
                    }
                } else {
                    alert("error");
                }
            }
        });

    });

    $("body").delegate(".addcourse-button", "click", function(e) {
        triggerModalSuccess({id: "modal-create-course-form", title: "Crear Curso", effect: "md-effect-17"});
    });

    $("body").delegate(".addchapter-button", "click", function(e) {
        triggerModalSuccess({id: "modal-create-chapter-form", title: "Crear Unidad", effect: "md-effect-17"});
    });

    $("body").delegate(".addlesson-button", "click", function(e) {
        $("#modal-create-lesson-form #lesson_chapter_id").val($(this).attr("chapter"));
        triggerModalSuccess({id: "modal-create-lesson-form", title: "Crear Lección", effect: "md-effect-17"});
    });

    //init tinyMCE ONCE!
    // tinymce.init({
    //     mode: "none",
    //     plugins: [
    //         "advlist autolink lists link image charmap anchor",
    //         "searchreplace visualblocks code fullscreen",
    //         "insertdatetime media table contextmenu paste jbimages"
    //     ],
    //     relative_urls: false,
    //     convert_urls: false,
    //     remove_script_host : false,
    //     menubar: "edit insert format view table",
    //     toolbar1: "undo redo | styleselect | bold italic | link image media | code | fullscreen",
    //     toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
    // });

});