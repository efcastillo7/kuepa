$(function() {
    $(".knob").knob(knob_values);
    
    $("body").delegate(".component_edit_link", "click", function(e) {
        var target = $(this).attr("target");
        triggerModalSuccess({id: target, title: "Editar", effect: "md-effect-17"});
    });
});