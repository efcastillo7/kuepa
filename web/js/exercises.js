var stepLevel = 0;
var beforeSerializeCallback = function() {
};
var saveCallback = function() {
};
var types = {
    "introduction": "Estímulo",
    "multiple-choice": "Elección múltiple",
    "multiple-choice2": "Elección múltiple",
    "complete": "Rellenar Espacios",
    "open": "Respuesta abierta",
    "relation": "Relacionar",
    "interactive": "Zonas interactivas"
};

$(function() {

    //Initiates the main exercise editor
    initMainDataEdition();

    //Adjusts the layout on window resize
    $(window).resize(adjustLayout);
    adjustLayout();
});

/**
 * Initiates the main exercise editor
 * @returns {void}
 */
function initMainDataEdition() {

    //Tab navigation control
    $("#exerciseTab li a").click(function(e) {
        if ($(this).attr("href") === "#exerciseQuestions" && $("#exerciseId").val() === "") {
            alert("Por favor complete los datos de la ejercitación primero y presione guardar");
            e.preventDefault();
            return false;
        }

        //Initiates the question list editor
        initQuestionListEdition();
        adjustLayout();
    });

    //Tooltips
    $(".hasTooltip").each(function() {
        var $this = $(this);
        $this.tooltip({title: types[$this.parents(".question-list").attr("data-type")]});
    });

    emulateAffix($(".exercise-edit-header", $("#mainExerciseData")), {offset: 50});

    //tinyMCE for textareas
    tinymce.init({selector: '.tinymce', width: $(".create-exerice-form :text:first").width()});

    //ajaxForm for main exercise data
    $(".create-exerice-form").ajaxForm({
        dataType: 'json',
        beforeSerialize: function() {
            $("[name='exercise[description]']").html(tinymce.get($("[name='exercise[description]']").attr("id")).getContent());
        },
        beforeSubmit: function() {
            $("#btn-save-ex-info").text("Guardando...");
        },
        success: function(data) {
            if (data.status === "success") {
                $("#exerciseId").val(data.exercise_id);
                $("#btn-save-ex-info").text("Guardado!");
                setTimeout(function() {
                    $("#btn-save-ex-info").text($("#btn-save-ex-info").attr("data-text"));
                }, 3000);
            } else {
                alert("Se produjo un error al guardar la ejercitación");
            }
        }
    });
}

/**
 * Initiates the question list editor
 * @returns {void}
 */
function initQuestionListEdition() {

    var $scope = $("#mainEditor");

    //Main exercise data cancel button
    $("#btn-cancel-ex-info").click(function(e) {
        e.preventDefault();
    });

    //Adds an introduction to the exercise
    $(".addIntroduction", $scope).click(onAddItemToExerciseClicked);

    //Adds a question to the exercise
    $(".addQuestion li", $scope).click(onAddItemToExerciseClicked);

    //When a question is removed from the main question list
    $(".question-list .remove", $scope).click(onRemoveIntroductionClicked);

    //When a question is editted
    $(".question-list .edit", $scope).click(onEditExerciseClicked);

    //Adds sorting to the exercise questions
    $(".container", $scope).sortable({
        axis: "y",
        deactivate: onQuestionOrdered
    });

    emulateAffix($(".exercise-edit-header", $scope), {offset: 50});

    //Update exercises count for the main exercise
    updateExercisesCount($scope);

    //Updates the exercise numbers
    updateOrderNumbers($scope);
}

/**
 * Initiates the introduction editor
 * @returns {void}
 */
function initIntroductionEditor() {

    var $scope = $("#exerciseEditor");
    var $fromScope = $("#mainEditor");

    //Adds a question to the exercise
    $(".addQuestion li", $scope).click(onAddItemToExerciseClicked);

    //When a question is removed from the main question list
    $(".question-list .remove", $scope).click(onRemoveIntroductionClicked);

    //When a question is editted
    $(".question-list .edit", $scope).click(onEditExerciseClicked);

    //Adds sorting to the exercise questions
    $(".container", $scope).sortable({
        axis: "y",
        deactivate: onQuestionOrdered
    });

    $(".question-type span", $scope).text(types[$(".question_type", $scope).val()] + ": ");

    emulateAffix($(".exercise-edit-header", $scope), {offset: 50});

    //Update exercises count for the main exercise
    initQuestionForm($scope, $fromScope);
    updateExercisesCount($scope);
    updateOrderNumbers($scope);

}

/**
 *
 * @param {jQuery} $scope
 * @param {jQuery} $fromScope
 * @returns {void}
 */
function initQuestionForm($scope, $fromScope) {

    saveCallback = function() {
    };
    beforeSerializeCallback = function() {
    };

    adjustLayout();
    initMinimizable($scope);

    //tinyMCE for textareas
    tinymce.init({selector: '.tinymce', width: $(".edit-question-form :text:first", $scope).width()});

    //ajaxForm for main exercise data
    $(".edit-question-form", $scope).ajaxForm({
        dataType: 'json',
        beforeSerialize: function() {
            $("[name='exerciseQuestion[description]']", $scope).html(tinymce.get($("[name='exerciseQuestion[description]']", $scope).attr("id")).getContent());
            beforeSerializeCallback();
        },
        beforeSubmit: function() {
            $(".save span", $scope).text("Guardando...");
        },
        success: function(data) {
            if (data.status === "success") {
                $("#exerciseId", $scope).val(data.exercise_id);
                $(".save span", $scope).text("Guardado!");
                setTimeout(function() {
                    $(".save span", $scope).text($(".save", $scope).attr("data-text"));
                }, 3000);
                //Updates the title in the list
                $("[data-id=" + $(".question_id", $scope).val() + "] .title").text($("[name='exerciseQuestion[title]']", $scope).val());
                $("[data-id=" + $(".question_id", $scope).val() + "] .label-info").text(data.value + " punto(s)");

                $(".form-errors", $scope).html("");

                saveCallback();
            } else {
                var errors = JSON.parse(data.errors);
                $(".form-errors", $scope).html(errors.join("<br />"));
            }
        }
    });

    $(".back", $scope).click(function(e) {

        e.preventDefault();

        if (window.confirm("¿Desea guardar antes de volver?")) {

            $(".edit-question-form", $scope).trigger("submit");
            saveCallback = function() {
                gotoPanel($fromScope.index() + 1);
            };
        }

        gotoPanel($fromScope.index() + 1);

    });
}

/**
 *
 * @param {string} type
 * @param {jQuery} $fromScope
 * @returns {void}
 */
function initQuestionEditor(type, $fromScope) {

    var $scope = $("#questionEditor");
    $(".question-type span", $scope).text(types[$(".question_type", $scope).val()]);

    emulateAffix($(".exercise-edit-header", $scope), {offset: 50});

    initQuestionForm($scope, $fromScope);

    var type = $(".question_type", $scope).val();

    switch (type) {
        case "complete": initQuestionComplete(); break;
        case "multiple-choice": case "multiple-choice2": initQuestionMultiple(); break;
        case "relation": initQuestionRelation(); break;
        case "interactive": initQuestionInteractive(); break;
    }

}

function initQuestionComplete() {

    var $scope = $("#questionEditor");

    $("textarea.exercise-complete", $scope).keyup(function() {
        var $this = $(this);
        var text = $this.val();
        var regExp = /\[(.*?)\]/g;
        var matches = text.match(regExp);

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
                }
            }

            $(".values-container .complete-value:gt(" + (matches.length - 1) + ")").remove();

        } else {

            $(".values-container .complete-value").remove();

        }

    });

}

function initQuestionMultiple() {

    var $scope = $("#questionEditor");
    var $checks = $(".answer-list .check", $scope);

    $checks.click(onAnswerCheckClick);//When a question is removed from the main question list
    $(".answer-list .remove", $scope).click(onRemoveAnswerClicked);
    $(".add-answer", $scope).click(onAddAnswerClicked);

}

function initQuestionRelation() {

    var $scope = $("#questionEditor");

    $(".answer-list.answer .remove", $scope).click(onRemoveAnswerClicked);
    $(".answer-list.relation .remove", $scope).click(onRemoveAnswerItemClicked);

    $(".add-relation-answer", $scope).click(onAddRelationAnswerClicked);
    $(".add-relation-item", $scope).click(onAddRelationItemClicked);

}

function initQuestionInteractive() {
    var $scope = $("#questionEditor");
    var $stage = $("#stage");

    var stage = new Kinetic.Stage({
        container: 'stage',
        width: $stage.width(),
        height: $stage.height()
    });

    var layer = new Kinetic.Layer();
    stage.add(layer);

    var newArc;
    var isDown = false;

    stage.on("contentMousedown", function() {
        var mouse = stage.getMousePosition();
        newArc = new Kinetic.Circle({
            x: mouse.x,
            y: mouse.y,
            radius: .25,
            fill: randomColor(),
            stroke: "lightgray",
            strokeWidth: 3
        });
        layer.add(newArc);
        layer.draw();
        isDown = true;
    });

    stage.on("contentMousemove", function() {
        if (!isDown) {
            return;
        }
        var mouse = stage.getMousePosition();
        var dx = mouse.x - newArc.getX();
        var dy = mouse.y - newArc.getY();
        var radius = Math.sqrt(dx * dx + dy * dy);
        newArc.setRadius(radius);
        layer.draw();
    });

    $(stage.getContent()).on('mouseup', function() {
        isDown = false;
        newArc = null;
    });


    function randomColor() {
        return ('#' + Math.floor(Math.random() * 16777215).toString(16));
    }

    layer.draw();
}

function initMinimizable($scope) {
    $(".minimize", $scope).click(function() {
        var $this = $(this);

        $this.find("i").toggleClass("icon-chevron-up").toggleClass("icon-chevron-down");
        $(".common-form").slideToggle(500);
    });
}

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
            .appendTo($(".answers-container", $scope))
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
                    .attr("name", "relation-answer-text-" + answer_id);
            $clon.find(".value").attr("name", "relation-answer-value-" + answer_id);

            updateAnswersItemsSelects();
            updateAnswersOrderNumbers();

        } else {
            alert("Se produjo un error al crear la respuesta");
        }
    }, "JSON");
}

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
            .appendTo($(".items-container", $scope))
            .find(".title").text("Creando...");



    $.post("/exercise/addAnswerItem", params, function(data) {

        if (data.status === "success") {

            //Introduction question_id
            var answer_item_id = data.answer_item_id;

            $clon
                    .removeClass("loading")
                    .attr("data-id", answer_item_id)
                    .find(".remove").click(onRemoveAnswerItemClicked);
            $clon.find(".relation").replaceWith(getUpdatedRelationSelect(answer_item_id));
            $clon.find(".value").attr("name", "relation-item-related-" + answer_item_id);

        } else {
            alert("Se produjo un error al crear la relación");
        }
    }, "JSON");
}

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

/**
 * Triggered when an answer is removed
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

/**
 * Emulates Bootstrap Affix (Missing!)
 * @param {jQuery} $el
 * @param {object} config
 * @returns {void}
 */
function emulateAffix($el, config) {

    if (!$el.length)
        return;

    var def = {
        offset: 0
    };

    var options = $.extend(config, def);
    var stickyTop = $el.offset().top;

    $(window).scroll(function() {

        //If the panel is not active, cancels
        if ($el.parents(".editor").is(":not(.active)")) {
            return;
        }

        var windowTop = $(window).scrollTop();

        if (stickyTop < (windowTop + options.offset)) {
            if ($el.is(":not(.affix)")) {
                $el.addClass("affix");
            }
        } else {
            $el.removeClass("affix");
        }

    });

}

/**
 *
 * Triggered when add button pressed
 * @param {Event} e
 * @returns {void}
 */
function onAddItemToExerciseClicked(e) {
    var $this = $(this);
    var $scope = $this.parents(".editor");
    var $clon = $(".question-list.ignore").clone(false);
    var type = $this.attr("data-type");
    var $icon = $this.find("i");

    addItemToExercise($scope, $clon, type, $icon);
}

/**
 * Adds an item to the exercise
 * @param {jQuery} $scope
 * @param {jQuery} $clon
 * @param {string} type
 * @param {jQuery} $icon
 * @returns {void}
 */
function addItemToExercise($scope, $clon, type, $icon) {

    //Params sent to the API
    var params = {
        exercise_id: $("#exerciseId").val(),
        type: type
    };

    //If its a subquestion adds a parent_id
    if ($scope.is("#exerciseEditor")) {
        params.parent_id = $(".question_id", $scope).val();
    }

    //Adds client-side
    $clon
            .removeClass("ignore")
            .addClass("loading")
            .addClass(type)
            .appendTo($(".container", $scope))
            .find(".title").text("Creando...");

    //Tries to create the item
    $.post("/exercise/addItem", params, function(data) {

        if (data.status === "success") {

            //Introduction question_id
            var question_id = data.question_id;

            $clon
                    .removeClass("loading")
                    .attr("data-id", question_id)
                    .find(".remove").click(onRemoveIntroductionClicked);
            $clon.find(".icon:not(.handle)").addClass($icon.attr("class"));
            $clon.find(".edit").click(onEditExerciseClicked);
            $clon.find(".title").text("Sin título");

            updateExercisesCount($scope);
            updateOrderNumbers($scope);
        } else {
            alert("Se produjo un error al crear el estímulo");
        }
    }, "JSON");

}

/**
 * Updates the exercise count
 * @param {jQuery} $scope
 * @returns {void}
 */
function updateExercisesCount($scope) {
    var $number = $(".exercise-edit-header .count .number", $scope);
    var $label = $(".exercise-edit-header .count .info", $scope);
    var count = $(".question-list:not(.ignore)", $scope).length;

    $number.text(count > 0 ? count : "");
    $label.text(count > 0 ? count > 1 ? " ejercicios" : " ejercicio" : "Sin ejercicios");
}

/**
 * Updates the order indicators
 * @param {jQuery} $scope
 * @param {boolean} store
 * @returns {void}
 */
function updateOrderNumbers($scope, store) {

    store = !!store;

    var data = {
        exercise_id: $("#exerciseId").val()
    };

    $(".question-list:not(.ignore)", $scope).each(function() {
        var $this = $(this);
        var order = $this.index() + 1;
        data[$this.attr("data-id")] = order;
        $this.find(".order").text(order);
    });

    if (store) {
        $.post("/exercise/order", data, function(data) {
        }, "JSON");
    }
}

/**
 * Updates the order indicators
 * @param {jQuery} $scope
 * @param {boolean} store
 * @returns {void}
 */
function updateAnswersOrderNumbers() {

    $(".answer-list.answer:not(.ignore)").each(function() {
        var $this = $(this);
        var order = $this.index();
        $this.find(".order").text(order - 1);
    });

}

/**
 * Triggered when an introduction is removed
 * @param {Event} e
 * @returns {void}
 */
function onRemoveIntroductionClicked(e) {

    if (window.confirm("¿Está seguro que desea remover este ítem?")) {

        var $introduction = $(this).parents(".question-list");
        $introduction.addClass("loading");

        if ($introduction.attr("data-id") !== "") {
            var params = {
                exercise_id: $("#exerciseId").val(),
                question_id: $introduction.attr("data-id")
            };

            $.post("/exercise/removeItem", params, function(data) {

                if (data.status === "success") {

                    $introduction.remove();
                    updateExercisesCount($("#mainEditor"));
                    updateOrderNumbers($("#mainEditor"));


                } else {
                    alert("Se produjo un error al crear el estímulo");
                }
            }, "JSON");
        } else {
            $introduction.remove();
            updateExercisesCount($("#mainEditor"));
            updateOrderNumbers($("#mainEditor"));
        }

    }
}

/**
 * Triggered when an introduction is edited
 * @returns {void}
 */
function onEditExerciseClicked() {
    var $this = $(this);
    var $fromScope = $this.parents(".editor");
    var $question = $this.parents(".question-list");
    var question_id = $question.attr("data-id");
    var exercise_id = $("#exerciseId").val();
    var type = $question.attr("data-type");
    if (type === "introduction") {
        var $targetPane = $("#exerciseEditor");
        var targetPaneN = 2;
    } else {
        var $targetPane = $("#questionEditor");
        var targetPaneN = 3;
    }

    $question.addClass("loading");

    $.post("/exercise/editItemForm", {question_id: question_id, exercise_id: exercise_id}, function(data) {
        $question.removeClass("loading");
        $targetPane.html(data.form).find(".edit-question-form").append(data.template);
        gotoPanel(targetPaneN);
        if (type === "introduction") {
            initIntroductionEditor();
        } else {
            initQuestionEditor(type, $fromScope);
        }
    }, "JSON");
}

/**
 *
 * @returns {void}
 */
function onEditQuestionClicked() {
    nextPanel();
}

/**
 *
 * @param {Event} event
 * @param {Object} ui
 * @returns {void}
 */
function onQuestionOrdered(event, ui) {
    var $scope = $(ui.item).parents(".editor");
    updateOrderNumbers($scope, true);
}

/**
 *
 * @param {Event} event
 * @param {Object} ui
 * @returns {void}
 */
function onAnswerOrdered(event, ui) {
    //TODO from Kuepa...
}

/**
 *
 * @returns {void}
 */
function adjustLayout() {
    var $panels = $("#exerciseQuestions .scroll > div:not(.clearfix)");
    var $container = $(".exercises.container");
    $panels.width($container.width());
    $panels.removeClass("active").eq(stepLevel).addClass("active");
    $("#exerciseQuestions .scroll").width($panels.length * $container.width());
}

/**
 *
 * @returns {void}
 */
function nextPanel() {
    var $scroll = $("#exerciseQuestions .scroll");
    var $panels = $("#exerciseQuestions .scroll > div:not(.clearfix)");
    var $container = $("#exerciseQuestions");

    if (stepLevel < ($panels.length - 1)) {

        $(".editor .affix").removeClass("affix");

        stepLevel++;
        $panels.removeClass("active").eq(stepLevel).addClass("active");
        $scroll.animate({
            marginLeft: $container.width() * -stepLevel
        }, 500);
    }
}

/**
 *
 * @returns {void}
 */
function prevPanel() {
    var $scroll = $("#exerciseQuestions .scroll");
    var $panels = $("#exerciseQuestions .scroll > div:not(.clearfix)");
    var $container = $("#exerciseQuestions");

    if (stepLevel > 0) {

        $(".editor .affix").removeClass("affix");

        stepLevel--;
        $panels.removeClass("active").eq(stepLevel).addClass("active");
        $scroll.animate({
            marginLeft: -$container.width() * stepLevel
        }, 500);
    }
}

/**
 *
 * @param {Integer} n
 * @returns {void}
 */
function gotoPanel(n) {
    var $scroll = $("#exerciseQuestions .scroll");
    var $panels = $("#exerciseQuestions .scroll > div:not(.clearfix)");
    var $container = $("#exerciseQuestions");

    n--;

    $(".editor .affix").removeClass("affix");
    $panels.removeClass("active").eq(n).addClass("active");

    if (n >= 0 && n < $panels.length) {
        stepLevel = n;
        $scroll.animate({
            marginLeft: $container.width() * -stepLevel
        }, 500);
    }
}