<div class="eg-expander expanded bg-<?php echo $course->getColor() ?>-alt-2">
    <div class="eg-expander-inner">
        <div class="eg-close-container"><span class="eg-close"></span></div>
        <div class="eg-thumb bg-<?php echo $course->getColor() ?>-alt-1">
            <img src="<?php echo $course->getThumbnailPath() ?>">
        </div>
        <div class="data">
            <div><a class="eg-btn-see" href="<?php echo url_for("course/details?id=" . $course->getId()) ?>" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="Ver detalle del curso"><i></i></a></div>
            <?php if ($sf_user->hasCredential("editor")): ?>
                <div><a class="component_edit_link eg-btn-edt" target="modal-create-course-form-<?php echo $course->getId() ?>" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="Editar"><i></i></a></div>
            <?php endif; ?>
            <?php if ($sf_user->hasCredential("docente")): ?>
                <div><a class="eg-btn-sts" href="<?php echo url_for("stats/class?course_id=" . $course->getId()) ?>" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="Estadísticas"><i></i></a></div>
            <?php endif; ?>
        </div>
        <div class="eg-details">
            <p class="title clearmargin"><a href="<?php echo url_for("course/details?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a></p>
            <p class="subtitle"><?php echo $course->getCacheCompletedStatus(); ?>% Completado</p>
            <div class="description margintop">
                <div class="eg-description sb-alpha">
                    <?php echo $course->getRaw('description'); ?>
                </div>
            </div>
        </div>
        <div class="eg-multimenu course-data-container">
            <?php include_partial('views/navigator/chapter_list', array('chapters' => $chapters, 'course' => $course, 'profile' => $profile)) ?>
        </div>
    </div>
</div>
<?php if ($sf_user->hasCredential("editor")): ?>
<?php include_component('course', 'Modalform', array('id' => $course->getId())) ?>
<?php endif; ?>
