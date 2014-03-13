var stepLevel = 0;
var beforeSerializeCallback = saveCallback = onTinyMCEChangeCallback = function() {};
var types = {
    "introduction": "Estímulo",
    "multiple-choice": "Elección múltiple",
    "multiple-choice2": "Elección múltiple",
    "complete": "Rellenar Espacios",
    "open": "Respuesta abierta",
    "relation": "Relacionar",
    "interactive": "Zonas interactivas"
};
var modified = false;

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
    $("#exerciseTab li a").unbind().click(function(e) {
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
    tinymce.init({
        selector: '.tinymce',
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
    $(".addIntroduction", $scope).unbind().click(onAddItemToExerciseClicked);

    //Adds a question to the exercise
    $(".addQuestion li", $scope).unbind().click(onAddItemToExerciseClicked);

    //When a question is removed from the main question list
    $(".question-list .remove", $scope).unbind().click(onRemoveIntroductionClicked);

    //When a question is editted
    $(".question-list .edit", $scope).unbind().click(onEditExerciseClicked);

    //Adds sorting to the exercise questions
    $(".container", $scope).sortable({
        axis: "y",
        deactivate: onQuestionOrdered
    });

    modified = false;

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
    $(".addQuestion li", $scope).unbind().click(onAddItemToExerciseClicked);

    //When a question is removed from the main question list
    $(".question-list .remove", $scope).unbind().click(onRemoveIntroductionClicked);

    //When a question is editted
    $(".question-list .edit", $scope).unbind().click(onEditExerciseClicked);

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

    saveCallback = beforeSerializeCallback = onTinyMCEChangeCallback = function(){};

    adjustLayout();
    initMinimizable($scope);

    //tinyMCE for textareas
    tinymce.init({
        setup: function(editor) {
            editor.on('change', function(e) {
                modified = true;
                onTinyMCEChangeCallback(e);
            });
        },
        selector: '.tinymce',
        width: $(".edit-question-form :text:first",$scope).width(),
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
            if (data.status == "success") {
                $("#exerciseId", $scope).val(data.exercise_id);
                $(".save span", $scope).text("Guardado!");
                setTimeout(function() {
                    $(".save span", $scope).text($(".save", $scope).attr("data-text"));
                }, 3000);
                //Updates the title in the list
                $("[data-id=" + $(".question_id", $scope).val() + "] .title").text($("[name='exerciseQuestion[title]']", $scope).val());
                $("[data-id=" + $(".question_id", $scope).val() + "] .label-info").text(data.value + " punto(s)");

                $(".form-errors", $scope).html("");

                modified = false;
                saveCallback();
            } else {
                var errors = JSON.parse(data.errors);
                $(".form-errors", $scope).html(errors.join("<br />"));
            }
        }
    });

    $(".edit-question-form",$scope).find("input,select,textarea").change(function(){
       modified = true;
    });

    $(".back", $scope).click(function(e) {

        e.preventDefault();

        if(modified){

            if (window.confirm("¿Desea guardar antes de volver?")) {

                $(".edit-question-form", $scope).trigger("submit");
                saveCallback = function() {
                    gotoPanel($fromScope.index() + 1);
                };
            }

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
        case "complete":
            initQuestionComplete();
            break;
        case "multiple-choice":
        case "multiple-choice2":
            initQuestionMultiple();
            break;
        case "relation":
            initQuestionRelation();
            break;
        case "interactive":
            initQuestionInteractive();
            break;
    }

}

/**
 * Adds option to minimize question content
 * @param {jQuery} $scope
 * @returns {undefined}
 */
function initMinimizable($scope) {
    $(".minimize", $scope).click(function() {
        var $this = $(this);

        $this.find("i").toggleClass("icon-chevron-up").toggleClass("icon-chevron-down");
        $(".common-form").slideToggle(500);
    });
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

    e.preventDefault();

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
            .attr("data-type",type)
            .appendTo($(".container", $scope))
            .find(".title").text("Creando...");

    if(type === "introduction"){
        $("<div class='label pull-right'>0 pregunta(s)</div>").insertBefore($(".handle",$clon));
    }

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
    $label.text(count > 0 ? count > 1 ? " ejercicios" : " ejercicio" : " Sin ejercicios");
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
    var $targetPane;
    var targetPaneN;

    if (type === "introduction") {
        $targetPane = $("#exerciseEditor");
        targetPaneN = 2;
    } else {
        $targetPane = $("#questionEditor");
        targetPaneN = 3;
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
    //TODO
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