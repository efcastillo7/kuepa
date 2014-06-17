$(document).ready(function(){

  $(".knob").knob({});

  /* Muestra/Oculta las lecciones de la unidad*/
  $(".btn-lessons").click(function(){
    var target = $(this).data("target");

    if( $(target).hasClass("none") ){
      $(target).removeClass("none").addClass("displayed");
      $(".progreso").removeClass("none").css("width","340px");
      $(this).find(".ico-arrow-table").addClass("rotate");

      //actualiza el margin-top de la tabla general-data
      var margintop = ($(".specific-data .title-level-1").height()+10) + ($(".specific-data .title-level-2").height()) ;
      $(".comparative-table.general-data").css("margin-top",margintop+1);

    }else{
      $(target).addClass("none");
      $(".collapsable").addClass("none");
      $(this).find(".ico-arrow-table").removeClass("rotate");

      //actualiza el margin-top de la tabla general-data
      $(".comparative-table.general-data").css("margin-top",81);
    }

  });

  $(".button").click(function(){
    var target = $(this).data("target");

    if( $(target).hasClass("none") ){
      $(this).find(".ico-arrow-table").addClass("rotate");
      $(target).removeClass("none");
      $(target + ".progreso").css("width","85px").removeClass("column");
      $(target +".first").addClass("column");
    }else{
      $(target +".collapsable").not(".progreso").addClass("none");
      $(target + ".progreso").css("width","340px").addClass("column");
      $(this).find(".ico-arrow-table").removeClass("rotate");
      $(target +".first").removeClass("column");
    }
  });


  $(".wrap-box .bubble").click(function(){
    $(this).toggle();
    $(this).siblings(".big-bubble").toggle();
    $(this).siblings(".box").css("top","-45px");
  });

  $(".wrap-box .big-bubble").click(function(){
    $(this).toggle();
    $(this).siblings(".bubble").toggle();
    $(this).siblings(".box").css("top","0");
  });

    count_boxes();

    function count_boxes(){
        var counter = 0;
        $(".units .wrap-box").each(function(){
            counter++;
        });
        $(".units .content").css("width",(175*(counter+1.2)));
    }



});


$(document).ready(function ($) {
    "use strict";
    $('.scroleable').perfectScrollbar({suppressScrollY: true,wheelPropagation:true});

    $(document.body).on("click","#form_categories .dropdown-menu > li > a > input" , function(event) {
        var ckhbx = jQuery(this);
        ckhbx.prop('checked', !ckhbx.is(':checked') );
    });

    $(document.body).on("click","#form_categories .dropdown-menu > li"  , function(e) {
        var ckhbx = jQuery(this).find("input[type=checkbox]");
        ckhbx.prop('checked', !ckhbx.is(':checked') );
        if ( jQuery(this).parent().parent().hasClass("localidad") ){
          reload_college_groups();  
        };
        e.stopPropagation();
    });

/*      $( "#form_categories .btn-group.localidad .dropdown-menu > li" ).on("click", function(e) {
      reload_college_groups();
    });*/

});

function reload_college_groups(){
  var params = jQuery("[name*='groups[1]']").serialize()+"&category_id=2";

  jQuery.get("/stats/ReloadCategoryGroups",params,function(data){
    jQuery("#form_categories .btn-group.colegio ul.dropdown-menu").replaceWith(data.template);
  },'json');

}
