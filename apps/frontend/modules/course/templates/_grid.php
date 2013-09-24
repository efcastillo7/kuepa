<div class="eg-expander expanded bg-<?php echo $course->getColor() ?>-alt-2">
    <div class="eg-expander-inner">
        <div class="eg-close-container"><span class="eg-close"></span></div>
        <div class="eg-thumb bg-<?php echo $course->getColor() ?>-alt-1">
            <img src="<?php echo $course->getThumbnailPath() ?>">
        </div>
        <div class="eg-details">
            <p class="title clearmargin"><a href="<?php echo url_for("course/details?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a></p>
            <p class="subtitle"><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $course->getId()) ?>% Completado</p>
            <p class="data">7 Unidades  /  32 Lecciones  /  2h 40’52’’ / 5 Ejercicios  /  1 Evaluación</p>
            <p class="description margintop"><?php echo $course->getRaw('description'); ?></p>
            <?php if ($sf_user->hasCredential("docente")): ?>
            <a class="component_edit_link btn" target="modal-create-course-form-<?php echo $course->getId() ?>">Editar</a>
            <?php endif; ?>
        </div>
        <div class="eg-multimenu course-data-container">
            <?php include_partial('views/navigator/chapter_list', array('chapters' => $chapters, 'course' => $course, 'profile' => $profile)) ?>
        </div>
    </div>
</div>
<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('course', 'Modalform', array('id' => $course->getId())) ?>
<?php endif; ?>
