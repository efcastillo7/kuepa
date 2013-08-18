<div class="eg-expander expanded">
    <div class="eg-expander-inner">
        <div class="eg-close-container"><span class="eg-close"></span></div>
        <div class="eg-thumb">
            <img src="<?php echo $course->getThumbnail() ?>">
        </div>
        <div class="eg-details">
            <p class="title3 clearmargin"><?php echo $course->getName() ?></p>
            <p class="title5 gray2">40% Completado</p>
            <p class="small1 gray4">7 Unidades  /  32 Lecciones  /  2h 40’52’’ / 5 Ejercicios  /  1 Evaluación</p>
            <p class="margintop"><?php echo $course->getDescription() ?></p>
        </div>
        <div class="eg-multimenu course-data-container">
            <?php include_partial('views/navigator/chapter_list', array('chapters' => $chapters, 'course' => $course)) ?>
        </div>
    </div>
</div>