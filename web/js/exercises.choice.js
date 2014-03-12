function initQuestionMultiple() {

    var $scope = $("#questionEditor");
    var $checks = $(".answer-list .check", $scope);

    $checks.click(onAnswerCheckClick);//When a question is removed from the main question list
    $(".answer-list .remove", $scope).click(onRemoveAnswerClicked);
    $(".add-answer", $scope).click(onAddAnswerClicked);

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

    if (type === "multiple-choice") {
        $(".answer-list.correct", $scope).removeClass("correct");
        $(".isCorrect", $scope).val(0);
        if (!checked) {
            $this.parents(".answer-list")
                    .addClass("correct")
                    .find(".isCorrect").val(1);
        }
    } else if (type === "multiple-choice2") {
        $answer.toggleClass("correct");
        if ($answer.is(".correct")) {
            $answer.find(".isCorrect").val(1);
        } else {
            $answer.find(".isCorrect").val(0);
        }
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