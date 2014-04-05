<div class="subject-grid active">
    <ul id="eg-grid" class="eg-grid">
        <?php foreach ($enabled_courses as $course): ?>
        <li class="subject-item color-<?php echo $course->getColor() ?>">
            <a class="subject-link" href="<?php echo url_for('course/expanded?type=grid&course_id=' . $course->getId()) ?>">
                <div class="subject-buttonbox bg-<?php echo $course->getColor() ?> txt-center">
                    <div class="subject-image">
                        <img src="<?php echo $course->getThumbnailPath() ?>" alt="">
                    </div>
                    <div class="subject-title">
                        <p class="st-title"><?php echo $course->getName() ?></p>
                        <p class="st-progress"><?php echo $course->getCacheCompletedStatus(); ?>% Completado</p>
                    </div>
                    <div class="pbar-circle">
                        <input class="knob" value="<?php echo $course->getCacheCompletedStatus(); ?>" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                    </div>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
        <?php foreach ($display_courses as $course): ?>
        <li class="subject-item color-<?php echo $course->getColor() ?> blocked">
            <a class="subject-link" href="#">
                <div class="subject-buttonbox bg-<?php echo $course->getColor() ?> txt-center">
                    <div class="subject-image">
                        <img src="<?php echo $course->getThumbnailPath() ?>" alt="">
                    </div>
                    <div class="subject-title">
                        <p class="st-title"><?php echo $course->getName() ?></p>
                        <p class="st-progress">No Disponible</p>
                    </div>
                    <div class="pbar-circle">
                        <input class="knob" value="<?php echo $course->getCacheCompletedStatus(); ?>" data-fgColor="#fff" data-bgColor="#000" data-width="150" data-thickness=".09" data-skin="" data-readOnly=true data-displayInput=false >
                    </div>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
        <?php if ($sf_user->hasCredential("docente")): ?>
        <!-- Add course if has privilege -->
        <li class="subject-item">
            <a class="subject-link addcourse-button" href="#">
                <div class="subject-buttonbox txt-center subject-add">
                    <div class="subject-plus">+</div>
                    <div class="subject-title">
                        <p class="st-title">Agregar Curso</p>
                    </div>
                </div>
            </a>
        </li>
        <?php endif ?>  
    </ul>
</div>