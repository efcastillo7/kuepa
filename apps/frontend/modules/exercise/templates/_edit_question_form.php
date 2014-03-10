<input type="hidden" class="question_id" value="<?php echo $form->getObject()->getId(); ?>">
<input type="hidden" class="question_type" value="<?php echo $form->getObject()->getType(); ?>">
<form class="form-horizontal edit-question-form" action="<?php echo url_for("exercise/editItem") . ($form->isNew() ? "" : "?id=" . $form->getObject()->getId()) ?>" method="POST" id="create-question-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>" enctype='multipart/form-data'>
    <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">
    <div class="exercise-edit-header" data-spy="affix">
        <button class="btn-gray-light btn-small btn pull-right save" data-text="Guardar">
            <i class="icon-circle-arrow-up"></i>
            <span>Guardar</span>
        </button>

        <?php if ($form->getObject()->getType() == "introduction"): ?>
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
        <?php endif; ?>

        <button class="btn btn-small btn-gray-light pull-right back">
            <i class="icon-chevron-left"></i>Volver
        </button>

        <span class="question-type">
            <span class="info pull-left"></span>
        </span>

        <?php if ($form->getObject()->getType() == "introduction"): ?>
            <span class="count">
                <span class="pull-left number"></span>
                <span class="info pull-left">Sin ejercicios</span>
            </span>
        <?php endif; ?>

        <div class="clearfix"></div>
    </div>

    <div class="form-errors"></div>

    <div class="form-header">
        <div class="pull-right btn btn-small btn-gray-light minimize"><i class="icon-chevron-up"></i>&nbsp;</div>
        <div class="title5">Información principal</div>
        <div class="clearfix"></div>
    </div>

    <div class="common-form">

        <div class="control-group">
            <label class="control-label" for="inputQuestionTitle"><?php echo $form["title"]->renderLabel(); ?></label>
            <div class="controls">
                <?php echo $form["title"]->render(); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputContenido"><?php echo $form["description"]->renderLabel(); ?></label>
            <div class="controls">
                <?php echo $form["description"]->render(); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputContenido"><?php echo $form["value"]->renderLabel(); ?></label>
            <div class="controls">
                <?php
                if ($form->getObject()->getType() != "introduction"):
                    echo $form["value"]->render();
                else:
                    ?>
                    <input type="text" class="input-middle" disabled="disabled" value="<?php echo ExerciseService::getInstance()->getQuestionValue($exercise_id, $form->getObject()->getId()) . " punto(s)" ?>">
                <?php
                endif;
                ?>
            </div>
        </div>
        <?php echo $form["type"]->render(); ?>
        <?php echo $form['_csrf_token']->render(); ?>
    </div>
</form>