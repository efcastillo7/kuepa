/**
 *
 * @returns {undefined}
 */
function initQuestionRelation() {

    var $scope = $("#questionEditor");

    $(".answer-list.answer .remove", $scope).click(onRemoveAnswerClicked);
    $(".answer-list.relation .remove", $scope).click(onRemoveAnswerItemClicked);

    $(".add-relation-answer", $scope).click(onAddRelationAnswerClicked);
    $(".add-relation-item", $scope).click(onAddRelationItemClicked);

}

/**
 * Adds a relation answer
 * @param {Event} e
 * @returns {undefined}
 */
function onAddRelationAnswerClicked(e) {
    e.preventDefault();

    var $scope = $("#questionEditor");
    var params = {
        question_id: $(".question_id", $scope).val()
    };

    var $clon = $(".answer-list.answer.ignore").clone(false);
    $clon
            .removeClass("ignore")
            .addClass("loading")
            .appendTo($(".answers-container", $scope));

    $.post("/exercise/addAnswer", params, function(data) {

        if (data.status === "success") {

            //Introduction question_id
            var answer_id = data.answer_id;

            $clon
                    .removeClass("loading")
                    .attr("data-id", answer_id)
                    .find(".remove").click(onRemoveAnswerClicked);
            $clon.find(".title")
                    .attr("name", "relation-answer-text-" + answer_id);
            $clon.find(".value").attr("name", "relation-answer-value-" + answer_id);

            updateAnswersItemsSelects();
            updateAnswersOrderNumbers();

        } else {
            alert("Se produjo un error al crear la respuesta");
        }
    }, "JSON");
}


/**
 *
 * @param {Event} e
 * @returns {void}
 */
function onAddRelationItemClicked(e) {
    e.preventDefault();

    if (!$(".answers-container .answer-list.answer").length) {
        alert("Primero debe crear al menos una respuesta");
        return;
    }

    var $scope = $("#questionEditor");
    var params = {
        question_id: $(".question_id", $scope).val()
    };

    var $clon = $(".answer-list.relation.ignore").clone(false);
    $clon
            .removeClass("ignore")
            .addClass("loading")
            .appendTo($(".items-container", $scope));



    $.post("/exercise/addAnswerItem", params, function(data) {

        if (data.status === "success") {

            //Introduction question_id
            var answer_item_id = data.answer_item_id;

            $clon
                    .removeClass("loading")
                    .attr("data-id", answer_item_id)
                    .find(".remove").click(onRemoveAnswerItemClicked);
            $clon.find(".relation").replaceWith(getUpdatedRelationSelect(answer_item_id));
            $clon.find(".title").attr("name", "relation-text-related-" + answer_item_id);
            $clon.find(".value").attr("name", "relation-item-related-" + answer_item_id);

        } else {
            alert("Se produjo un error al crear la relación");
        }
    }, "JSON");
}

/**
 * Updates the answers selects
 * @returns {void}
 */
function updateAnswersItemsSelects() {
    $("select.relation", ".items-container").each(function() {
        var $this = $(this);
        var $answerItem = $this.parents(".answer-list.relation");
        var answer_item_id = $answerItem.attr("data-id");
        var selectedIndex = $("option:selected", $this).index();
        var selectedValue = $("option:selected", $this).val();
        $this.replaceWith(getUpdatedRelationSelect(answer_item_id, selectedIndex, selectedValue));
    });
}

/**
 * Refreshes the relation select
 * @param {int} answer_item_id
 * @param {int} selectedIndex
 * @param {string} selectedValue
 * @returns {jQuery}
 */
function getUpdatedRelationSelect(answer_item_id, selectedIndex, selectedValue) {
    var $answers = $(".answers-container .answer-list.answer");
    var $select = $("<select class='pull-right span2 relation'>").attr("name", "relation-item-related-" + answer_item_id);

    $answers.each(function(i) {
        var $this = $(this);
        $select.append("<option value='" + $this.attr("data-id") + "'>" + (i + 1) + "</option>");

        if (!!selectedIndex & !selectedValue) {
            var $option = $("option:eq(" + selectedIndex + ")", $select);
            if ($option.length) {
                $option.attr("selected", "selected");
            }
        } else if (!!selectedValue) {
            var $option = $("option[value=" + selectedValue + "]", $select);
            if ($option.length) {
                $option.attr("selected", "selected");
            }
        } else {
            $("option:last", $select).attr("selected", "selected");
        }
    });

    return $select;
}


/**
 * Triggered when an answer item is removed
 * @param {Event} e
 * @returns {void}
 */
function onRemoveAnswerItemClicked(e) {

    e.preventDefault();

    if (window.confirm("¿Está seguro que desea remover esta relación?")) {

        var $answer = $(this).parents(".answer-list");
        $answer.addClass("loading");

        if ($answer.attr("data-id") !== "") {
            var params = {
                answer_item_id: $answer.attr("data-id")
            };

            $.post("/exercise/removeAnswerItem", params, function(data) {

                if (data.status === "success") {

                    $answer.remove();

                } else {
                    alert("Se produjo un error al eliminar la relación");
                }
            }, "JSON");
        } else {
            $answer.remove();
        }

    }
}