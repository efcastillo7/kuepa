/**
 * Initiates the multiple question form
 * @returns {undefined}
 */
function initQuestionMultiple() {

    var $scope = $("#questionEditor");
    var $checks = $(".answer-list .check", $scope);
    var $tfSelects = $(".true_false", $scope);
    var $type = $("select[name=type]");

    $type.change(onQuestionTypeChanged).trigger("change");

    $checks.click(onAnswerCheckClick);
    $tfSelects.click(onAnswerTFChange);

    //When a question is removed from the main question list
    $(".answer-list .remove", $scope).click(onRemoveAnswerClicked);
    $(".add-answer", $scope).click(onAddAnswerClicked);

}


function onQuestionTypeChanged(e) {
    $(".answer-container").removeClass("true-false").removeClass("multiple-choice").removeClass("multiple-choice2").addClass($(this).val());
}

/**
 * Triggered in Multiple Choice, when an answer is added
 * @param {Event} e
 * @returns {undefined}
 */
function onAddAnswerClicked(e) {
    e.preventDefault();

    var $scope = $("#questionEditor");
    var params = {
        question_id: $(".question_id", $scope).val()
    };

    var $clon = $(".answer-list.ignore").clone(false);
    $clon
            .removeClass("ignore")
            .addClass("loading")
            .appendTo($(".answer-container", $scope))
            .find(".title").text("Creando...");

    $.post("/exercise/addAnswer", params, function(data) {

        if (data.status === "success") {

            //Introduction question_id
            var answer_id = data.answer_id;

            $clon
                    .removeClass("loading")
                    .attr("data-id", answer_id)
                    .find(".remove").click(onRemoveAnswerClicked);
            $clon.find(".title")
                    .attr("name", "answer-text-" + answer_id);
            $clon.find(".value").attr("name", "answer-value-" + answer_id);
            $clon.find(".isCorrect").attr("name", "answer-correct-" + answer_id);
            $clon.find(".check").click(onAnswerCheckClick);
            $clon.find(".true_false").change(onAnswerTFChange);
            $clon.find("input").change(function() {
                modified = true;
            });

            tinymce.init({
                selector: '[name=answer-text-' + answer_id + ']',
                width: $(".create-exerice-form :text:first").width(),
                mode: "none",
                plugins: [
                    "advlist autolink lists link image charmap anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages"
                ],
                relative_urls: false,
                convert_urls: false,
                remove_script_host : false,
                menubar: "edit insert format view table",
                toolbar1: "undo redo | styleselect | bold italic | link image media | code | fullscreen",
                toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
            });

        } else {
            alert("Se produjo un error al crear la respuesta");
        }
    }, "JSON");
}

/**
 * Triggered when an answer is marked as correct
 * @param {Event} e
 * @returns {void}
 */
function onAnswerCheckClick(e) {
    e.preventDefault();

    var $this = $(this);
    var $scope = $("#questionEditor");
    var checked = $this.parents(".answer-list").is(".correct");
    var type = $("select[name=type]", $scope).val();
    var $answer = $this.parents(".answer-list");

    modified = true;

    switch (type) {
        case "multiple-choice":
            $(".answer-list.correct", $scope).removeClass("correct");
            $(".isCorrect", $scope).val(0);
            if (!checked) {
                $this.parents(".answer-list")
                        .addClass("correct")
                        .find(".isCorrect").val(1);
            }
            break;
        case "multiple-choice2": case "true-false":
            $answer.toggleClass("correct");
            if ($answer.is(".correct")) {
                $answer.find(".isCorrect").val(1);
                $answer.find(".true_false").val("true");
            } else {
                $answer.find(".isCorrect").val(0);
                $answer.find(".true_false").val("false");
            }
            break;
    }

}

/**
 * True / False switch
 * @param {Event} e
 * @returns {undefined}
 */
function onAnswerTFChange(e){
    var $this = $(this);
    var $scope = $("#questionEditor");
    var checked = $this.parents(".answer-list").is(".correct");
    var $answer = $this.parents(".answer-list");

    if($this.val() == "true"){
        $answer.addClass("correct");
        $answer.find(".isCorrect").val(1);
    }else{
        $answer.removeClass("correct");
        $answer.find(".isCorrect").val(0);
    }
}

/**
 * Triggered when an answer is removed
 * @param {Event} e
 * @returns {void}
 */
function onRemoveAnswerClicked(e) {

    e.preventDefault();

    if (window.confirm("¿Está seguro que desea remover esta respuesta?")) {

        var $answer = $(this).parents(".answer-list");
        $answer.addClass("loading");

        modified = true;

        if ($answer.attr("data-id") !== "") {
            var params = {
                answer_id: $answer.attr("data-id")
            };

            $.post("/exercise/removeAnswer", params, function(data) {

                if (data.status === "success") {

                    $answer.remove();
                    updateAnswersItemsSelects();

                } else {
                    alert("Se produjo un error al eliminar la respuesta");
                }
            }, "JSON");
        } else {
            $answer.remove();
        }

    }
}