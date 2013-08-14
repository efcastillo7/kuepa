$(function(){
   $('.subject-grid .subject-link').click(function(e){
       e.preventDefault();
       
       var parent = $(this).parent('li');
       
       if(parent.hasClass('eg-expanded')) {
           parent.find('.eg-expander').slideUp().promise().done(function(){
               parent.find('.eg-expander').remove();
               
               parent.removeClass('eg-expanded');
           });
       } else {
           $.getJSON($(this).attr('href'), function(response){
               parent.addClass('eg-expanded');
               
               var content = $(response.template).hide();
               
               parent.append(content);
               
               content.slideDown();
        });
       }
   });
});