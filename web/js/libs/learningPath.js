//learning_path
var lpService = new LearningPathService();

function addItemToPath(item){
    var template = $(".templates .cbp-path-item"),
    elem = template.clone().attr("id", null);

    $(".cbp-path-item-position", elem).html(item.position);
    $(".cbp-path-item-image > div", elem).addClass('bg-' + item.course.color + '-alt-1');
    $(".cbp-path-item-image img", elem).attr('src', item.course.image);

    $(".remove", elem).attr('id', item.id);

    $(".cbp-path-item-lesson", elem).html(item.lesson.name);
    $(".cbp-path-item-chapter", elem).html(item.chapter.name);
    $(".cbp-path-item-course", elem).html(item.course.name);

    $("a", elem).attr("href", '/lesson/view/' + item.course.id + '/' + item.chapter.id + '/' + item.lesson.id);

    $(elem).hide();

    //add
    $("#cbp-spmenu-s2").append(elem);

    $(elem).show('slide',{direction: 'right'});
}

function addItemsToPath(items){
    for(var i=0; i < items.length; i++){
        addItemToPath(items[i]);
    }
}


//init
$(document).ready(function(){
    "use strict";

    lpService.refresh({
        onSuccess: addItemsToPath
    });

    $("#edit-learning-path").click(function(){
        var obj = $(this);
        // if(obj.hasClass("editing")){
        //     $("#cbp-spmenu-s2").sortable('cancel');
        // }else{
        //     $("#cbp-spmenu-s2").sortable({items: '.cbp-path-item'});
        // }
        $("#cbp-spmenu-s2 .remove").toggle();
        obj.toggleClass("editing");
    });

    $("body").delegate(".cbp-path-item .remove", "click", function(e) {
        var obj = $(this).parent(".cbp-path-item");
        obj.slideUp().promise().done(function() {
            $(this).remove();
        });

        //no anda el onsuccess
        lpService.remove({
            id: $(this).attr('id'),
            onSuccess: function(data){
                obj.slideUp().promise().done(function() {
                    $(this).remove();
                });
            }
        });
    })

    
});

