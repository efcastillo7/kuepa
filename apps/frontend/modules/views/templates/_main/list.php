<div class="subject-list span10 offset1 margintop">
    <ul id="myCollapsible" class="lv-container unstyled">
        <?php foreach ($courses as $course): ?>
            <li class="subject-item">
                <a class="subject-link" href="<?php echo url_for('course/expanded?type=list&course_id=' . $course->getId()) ?>">
                    <div class="lv-icon bg-<?php echo $course->getColor() ?>-alt-1">
                        <img src="<?php echo $course->getThumbnailPath() ?>">
                    </div>
                    <p class="title3 HelveticaBd clearmargin"><i class="icon-chevron-right"></i><?php echo $course->getName() ?></p>
                    <p class="small1 HelveticaLt"><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $course->getId()) ?>% Completado</p>
                </a>
            </li>
        <?php endforeach; ?>
        <?php if ($sf_user->hasCredential("docente")): ?>
        <li class="subject-item addcourse-button">
            <div class="black" type="button">
                <div class="lv-icon">
                    
                </div>
                <p class="title3 HelveticaBd clearmargin"><i class="icon-chevron-right"></i>Agregar Curso</p>
                <p class="small1 HelveticaLt">&nbsp;</p>
            </div>
        </li>
        <?php endif ?>
    </ul>
</div>