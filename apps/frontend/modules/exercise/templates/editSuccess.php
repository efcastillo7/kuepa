<div class="exercises container">

    <div class="title3">Creación de nuevo ejercicio</div>

    <input type="hidden" id="exerciseId" value="<?php echo $exercise_id; ?>">

    <ul class="nav nav-tabs" id="exerciseTab">
        <li class="active"><a href="#mainExerciseData" data-toggle="tab">Datos</a></li>
        <li><a href="#exerciseQuestions" data-toggle="tab">Estímulos y preguntas</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="mainExerciseData">
            <form class="form-horizontal create-exerice-form" action="<?php echo url_for("exercise/create") . ($form->isNew() ? "" : "?id=" . $form->getObject()->getId()) ?>" method="POST" id="create-exerice-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>" enctype='multipart/form-data'>
                <div class="exercise-edit-header" data-spy="affix">
                    <button class="btn-gray-light btn-small btn pull-right" id="btn-save-ex-info">
                        <i class="icon-circle-arrow-up"></i> Guardar
                    </button>
                    <span class="question-type">
                        <span class="info pull-left">Ejercitación</span>
                    </span>
                    <div class="clearfix"></div>
                </div>

                <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">
                <div class="control-group">
                    <label class="control-label" for="inputExerciseName"><?php echo $form["title"]->renderLabel(); ?></label>
                    <div class="controls">
                        <?php echo $form["title"]->render(); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputExerciseDescription"><?php echo $form["description"]->renderLabel(); ?></label>
                    <div class="controls">
                        <?php echo $form["description"]->render(); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo $form["type"]->renderLabel(); ?></label>
                    <div class="controls">
                        <?php echo $form["type"]->render(); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAttempts"><?php echo $form["max_attemps"]->renderLabel(); ?></label>
                    <div class="controls">
                        <?php echo $form["max_attemps"]->render(); ?>
                    </div>
                </div>
                <!-- TODO Checkear si esto se va a usar o no -->
                <!--div class="control-group">
                    <label class="control-label">Límite de tiempo</label>
                    <div class="controls">
                        <div class="input-append">
                            <input class="input-xlarge" type="number" id="inputExerciseTimeLimit" name="exercise[time_limit]" placeholder="Límite de tiempo">
                            <span class="add-on">segs.</span>
                        </div>
                    </div>
                </div-->
                <div class="control-group">
                    <label class="control-label"><?php echo $form["start_time"]->renderLabel(); ?></label>
                    <div class="controls">
                        <?php echo $form['start_time']->render(array("class" => "input-xxlarge")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo $form["end_time"]->renderLabel(); ?></label>
                    <div class="controls">
                        <?php echo $form['end_time']->render(array("class" => "input-xxlarge")) ?>
                    </div>
                </div>
                <input type="hidden" name="exercise[course_id]" value="<?php echo $course_id; ?>">
                <?php echo $form['_csrf_token']->render(); ?>
            </form>
        </div>

        <div class="tab-pane" id="exerciseQuestions">
            <div class="scroll">
                <div id="mainEditor" class="editor">
                    <div class="exercise-edit-header" data-spy="affix">
                        <button class="btn-gray-light btn-small btn pull-right save">
                            <i class="icon-circle-arrow-up"></i> Guardar
                        </button>
                        <button class="btn-success btn-small btn pull-right addIntroduction" data-type="introduction">
                            <i class="icon-plus-sign"></i> Estímulo
                        </button>
                        <div class="btn-group pull-right">
                            <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-plus-sign"></i> Pregunta
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu addQuestion">
                                <li data-type="multiple-choice">
                                    <a href="#" class="question-multiple"><i class="icon-check"></i> Elección múltiple</a>
                                </li>
                                <li data-type="complete">
                                    <a href="#" class="question-complete"><i class="icon-pencil"></i> Rellenar espacios</a>
                                </li>
                                <li data-type="relation">
                                    <a href="#" class="question-relation"><i class="icon-resize-horizontal"></i> Relacionar</a>
                                </li>
                                <li data-type="open">
                                    <a href="#" class="question-open"><i class="icon-align-left"></i> Respuesta abierta</a>
                                </li>
                                <li data-type="interactive">
                                    <a href="#" class="question-interactive"><i class="icon-picture"></i> Zonas interactivas</a>
                                </li>
                            </ul>
                        </div>
                        <span class="count">
                            <span class="pull-left number"></span>
                            <span class="info pull-left">Sin ejercicios</span>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="container">

                        <?php
                        foreach ($questions as $question):
                            $title = $question->getTitle();
                            $value = ExerciseService::getInstance()->getQuestionValue($exercise_id, $question->getId());
                            ?>
                            <div class="question-list" data-id="<?php echo $question->getId(); ?>" data-type="<?php echo $question->getType(); ?>">
                                <button class="btn-gray-light btn-small pull-right edit">
                                    <i class="icon-chevron-right"></i>
                                </button>
                                <button class="btn-gray-light btn-small pull-right remove">
                                    <i class="icon-trash"></i> Eliminar
                                </button>
                                <?php if ($question->getType() == "introduction"): ?>
                                    <div class='label pull-right'><?php echo ExerciseService::getInstance()->getCountQuestions($exercise_id, $question->getId()); ?> pregunta(s)</div>
                                <?php endif; ?>
                                <div class="label label-info pull-right"><?php echo $value; ?> punto(s)</div>
                                <i class="icon-align-justify pull-left icon handle"></i>
                                <div class="pull-left order"></div>
                                <i class="pull-left icon hasTooltip <?php echo ExerciseService::getInstance()->getIconFor($question->getType()); ?>"></i>
                                <div class="title pull-left"><?php echo empty($title) ? "Sin título" : $title; ?></div>
                                <div class="clearfix"></div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div id="exerciseEditor" class="editor">
                    Panel 2
                </div>
                <div id="questionEditor" class="editor">
                    Panel 3
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div>

<!-- For cloning only -->
<div class="question-list ignore">
    <button class="btn-gray-light btn-small pull-right edit">
        <i class="icon-chevron-right"></i>
    </button>
    <button class="btn-gray-light btn-small pull-right remove">
        <i class="icon-trash"></i> Eliminar
    </button>
    <div class="label label-info pull-right">0 punto(s)</div>
    <i class="icon-align-justify pull-left icon handle"></i>
    <div class="pull-left order"></div>
    <i class="pull-left icon hasTooltip"></i>
    <div class="title pull-left">Sin título</div>
    <div class="clearfix"></div>
</div>

<script src="/js/exercises.choice.js" type="text/javascript"></script>
<script src="/js/exercises.relation.js" type="text/javascript"></script>
<script src="/js/exercises.zones.js" type="text/javascript"></script>
<script src="/js/exercises.complete.js" type="text/javascript"></script>
<script src="/js/exercises.js" type="text/javascript"></script>