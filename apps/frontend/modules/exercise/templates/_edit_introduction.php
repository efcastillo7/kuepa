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
            <div class="label label-info pull-right"><?php echo $value ?> punto(s)</div>
            <i class="icon-align-justify pull-left icon handle"></i>
            <div class="pull-left order"></div>
            <i class="pull-left hasTooltip icon <?php echo ExerciseService::getInstance()->getIconFor($question->getType()); ?>"></i>
            <div class="title pull-left"><?php echo empty($title) ? "Sin título" : $title; ?></div>
            <div class="clearfix"></div>
        </div>
    <?php endforeach; ?>
</div>