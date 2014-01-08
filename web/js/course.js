$(function() {
    $(".view-mode a").click(function(e) {
        e.preventDefault();
        var parent = $(this).parent();

        //hide active
        $("div.main > div.active").removeClass("active");
        $(".active", parent).removeClass("active");

        //set active
        $(this).addClass("active");
        $("div." + $(this).attr("target")).addClass("active");
    });

    //list function
    $('.subject-list a.subject-link').click(function(e) {
        e.preventDefault();

        var parent = $(this).parent('li');

        if (!parent.hasClass('eg-expanded')) {
            $.getJSON($(this).attr('href'), function(response) {
                parent.addClass('eg-expanded');
                // parent.animate({height: "760px"}, 50);

                var content = $(response.template).hide();

                parent.append(content);

                $("body").animate({ scrollTop: parent.offset().top - 60});

                //reload knob
                $(".knob", content).knob(knob_values);

                content.slideDown();
                // content.css("display","");

            });
        }else{
            parent.removeClass('eg-expanded');
            var obj = $("> div", parent);
            // $(".knob", parent).remove();
            obj.slideUp().promise().done(function() {
                $(this).remove();
            });
        }
    });

    //grid function
    $('body').delegate('.subject-grid .subject-link, .eg-close', 'click', function(e) {
        e.preventDefault();

        var parent = $(this).parent('li');

        $('.eg-expander').slideUp().promise().done(function() {
            var parent = $(this).parent('li');
            parent.removeClass('eg-expanded');
            $(this).remove();

            return;
        });

        if (!parent.hasClass('eg-expanded')) {
            $.getJSON($(this).attr('href'), function(response) {
                parent.addClass('eg-expanded');
                // parent.animate({height: "760px"}, 50);

                var content = $(response.template).hide();

                parent.append(content);

                //tooltips
                $("[rel='tooltip']", content).tooltip();

                $("body").animate({ scrollTop: parent.offset().top + 170});

                //reload knob
                $(".knob", content).knob(knob_values);

                content.slideDown();

                // content.css("display","");

            });
        }
    });

    $("body").delegate(".go-back", "click", function(e) {
        e.preventDefault();

        var parent_container = $(this).parent().parent().parent().parent();
        var parent = $(this).parent().parent().parent();
        var main = $("> div", parent_container).first();

        $(main).show('slide', {direction: "left"});
        $(parent).hide('slide', {direction: "right"});
    });


    $("body").delegate(".remote-link", "click", function(e) {
        e.preventDefault();

        var parent_container = $(this).parent().parent().parent().parent();
        var parent = $(this).parent().parent().parent();

        $.getJSON($(this).attr('href'), function(response) {
            //get container
            // var container = $(this).parent().parent().parent();
            var container = $(parent_container);

            var content = $(response.template).hide();

            $(container).append(content);

            $(parent).hide('slide', {direction: "left"});
            $(content, container).show('slide', {direction: "right"});

            //reload knob
            $(".knob", content).knob(knob_values);
        });
    });
});