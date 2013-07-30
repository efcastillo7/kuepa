$(function(){
   $('.coso').click(function(){
       var woot = $(this);
       $.getJSON($(this).attr('data-content-url'), function(response){
           woot.append(response.template);
       });
   });
});