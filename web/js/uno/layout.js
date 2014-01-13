$(function() {
    $(".knob").knob(knob_values);
    $(".knob-small").knob({
        height: 24
    });

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

    //left menu
    
    var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
        showLeft = document.getElementById( 'showLeft' ),
        showRight = document.getElementById( 'open-learning-path' ),
        menuRight = document.getElementById( 'cbp-spmenu-s2' ),
        body = document.body;

    if(showRight != undefined){
        showRight.onclick = function() {
            classie.toggle( menuRight, 'cbp-spmenu-open' );
        };
    }

    showLeft.onclick = function() {
        if(classie.hasClass(menuLeft, 'cbp-spmenu-open')){
            clearTimeout(menuTimeout);
            menuTimeout = -1;
        }
        classie.toggle( menuLeft, 'cbp-spmenu-open' );
    };

    $("#showLeft").mouseenter(function(event) {
        classie.addClass( menuLeft, 'cbp-spmenu-open' );
    });

    var menuTimeout = -1;

    $("#cbp-spmenu-s1, #showLeft").mouseleave(function(){
        if(menuTimeout < 0){
            menuTimeout = setTimeout(function(){
                classie.removeClass( menuLeft, 'cbp-spmenu-open' );
            }, 1000);
        }
    });

    $("#cbp-spmenu-s1, #showLeft").mouseenter(function(){
        clearTimeout(menuTimeout);
        menuTimeout = -1;
    });

    // tooltip
    $('[rel="tooltip"]').tooltip();


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