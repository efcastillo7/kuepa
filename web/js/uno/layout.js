$(function() {
    $(".knob").knob(knob_values);

    $("body").delegate(".component_edit_link", "click", function(e) {
        var target = $(this).attr("target");
        triggerModalSuccess({id: target, title: "Editar", effect: "md-effect-17"});
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
    tinymce.init({
        mode: "none",
        plugins: [
            "advlist autolink lists link image charmap anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        relative_urls: false,
        convert_urls: false,
        remove_script_host : false,
        menubar: "edit insert format view table",
        toolbar1: "undo redo | styleselect | bold italic | link image media | code | fullscreen",
        toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
    });

});