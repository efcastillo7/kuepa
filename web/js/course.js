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
});