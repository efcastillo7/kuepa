$(function() {
    $(".view-mode a").click(function(e){
      e.preventDefault();
      var parent = $(this).parent();

      //hide active
      $("div.main > div.active").removeClass("active");
      $(".active", parent).removeClass("active");

      //set active
      $(this).addClass("active");
      $("div." + $(this).attr("target")).addClass("active");



    });

    $('body').delegate('.subject-grid .subject-link, .eg-close', 'click', function(e) {
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
                $(".knob", content).knob(knob_values);

                content.slideDown();

            });
        }
    });

    $("body").delegate(".go-back", "click", function(e){
      e.preventDefault();

      var parent_container = $(this).parent().parent().parent().parent();
      var parent = $(this).parent().parent().parent();
      var main = $("> div", parent_container).first();

      $(main).show('slide',{ direction: "left"  });
      $(parent).hide('slide',{ direction: "right"  });      
    });


   $("body").delegate(".remote-link", "click", function(e){
      e.preventDefault();

      var parent_container = $(this).parent().parent().parent().parent();
      var parent = $(this).parent().parent().parent();

      $.getJSON($(this).attr('href'), function(response){
              //get container
              // var container = $(this).parent().parent().parent();
              var container = $(parent_container);

              var content = $(response.template).hide();
               
              $(container).append(content);

              $(parent).hide('slide',{ direction: "left"  });
              $(content, container).show('slide',{ direction: "right"  });

              //reload knob
              $(".knob").knob(knob_values);
        });
    });
});