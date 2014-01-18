<div class="subject-grid active span10 offset1 ">
    <ul id="eg-grid" class="eg-grid">
        <?php foreach ($courses as $course): ?>
            <li class="subject-item color-<?php echo $course->getColor() ?>">
                <a class="subject-link" href="<?php echo url_for('course/expanded?type=grid&course_id=' . $course->getId()) ?>">
                    <div class="subject-buttonbox bg-<?php echo $course->getColor() ?> txt-center">
                        <div class="subject-image">
                            <img src="<?php echo $course->getThumbnailPath() ?>" alt="">
                        </div>
                        <div class="subject-title">
                            <p class="st-title"><?php echo $course->getName() ?></p>
                            <p class="st-progress"><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $course->getId()) ?>% Completado</p>
                        </div>
                        <div class="pbar-circle">
                            <input class="knob" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $course->getId()) ?>" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                        </div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
        <!-- Add course if has privilege -->
        <?php if ($sf_user->hasCredential("docente")): ?>
        <li class="subject-item">
            <a class="subject-link addcourse-button" href="#">
                <div class="subject-buttonbox txt-center">
                    <div class="subject-title">
                        <p class="st-title">Agregar Curso</p>
                        <p class="st-progress">&nbsp; </p>
                    </div>
                    <div class="pbar-circle">
                        <input class="knob" value="0" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                    </div>
                </div>
            </a>
        </li>
        <?php endif ?>  
    </ul>
</div>