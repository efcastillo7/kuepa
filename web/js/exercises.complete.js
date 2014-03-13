/**
 *
 * @returns {undefined}
 */
function initQuestionComplete() {

    var $scope = $("#questionEditor");

    $("textarea.exercise-complete", $scope).keyup(function() {
        var $this = $(this);
        var text = $this.val();
        var regExp = /\[(.*?)\]/g;
        var matches = text.match(regExp);

        modified = true;

        if (matches) {
            for (i in matches) {
                var newText = matches[i].substr(1, matches[i].length - 2);
                var $value = $(".values-container .complete-value:eq(" + i + ")");
                if ($value.length) {
                    $(".text", $value).text(newText);
                    $("input:hidden", $value).val(newText);
                } else {
                    var $clon = $(".complete-value.ignore").clone().removeClass("ignore");
                    $(".text", $clon).text(newText);
                    $(".item_value", $clon).val(10).attr("name", "complete-value-new-" + i);
                    $(".item_text", $clon).val(newText).attr("name", "complete-text-new-" + i);
                    $clon.appendTo($(".values-container"));
                    $clon.find("input").change(function(){ modified = true;});
                }
            }

            $(".values-container .complete-value:gt(" + (matches.length - 1) + ")").remove();

        } else {

            $(".values-container .complete-value").remove();

        }

    });

}