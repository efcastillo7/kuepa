$(function() {
    $('.subject-grid .subject-link').click(function(e) {
        e.preventDefault();

        $('.eg-expander').slideUp().promise().done(function() {
            $(this).parent('li').removeClass('eg-expanded');
            $(this).remove();
        });

        var parent = $(this).parent('li');

        if (!parent.hasClass('eg-expanded')) {
            $.getJSON($(this).attr('href'), function(response) {
                parent.addClass('eg-expanded');

                var content = $(response.template).hide();

                parent.append(content);

                //reload knob
                $(".knob").knob(knob_values);

                content.slideDown();

            });
        }
    });

   $("body").delegate(".remote-link", "click", function(e){
      e.preventDefault();

      var parent = $(this).parent().parent().parent().parent();
      var content = 

      $.getJSON($(this).attr('href'), function(response){
              //get container
              // var container = $(this).parent().parent().parent();
              var container = $(parent);

              var content = $(response.template);
               
              $(container).append(content);

              //reload knob
              $(".knob").knob(knob_values);
        });
    });
});