<li class="subject-item">
    <a href="#" class="unit-tooltip" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $chapter->getId()) ?>% completado" style="width:<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $chapter->getId()) ?>%;"><div></div></a>
    <div id="<?php echo $chapter->getNameSlug() ?>" class="black" type="button" data-toggle="" data-target="#lv-chapter-<?php echo $chapter->getId() ?>">
        <p class="title5 HelveticaRoman clearmargin"><?php echo $chapter->getName() ?></p>
        <span class="unit-time">10'32''</span>
     </div>
     <div id="lv-chapter-<?php echo $chapter->getId() ?>" class="">
            <div class="row-fluid">
                <div class="span6">
                    <p class="gray4">
                        <?php echo $chapter->getDescription() ?>
                    </p>
                </div>
                <div class="span6">
                    <ul class="lv-lvlone unstyled">
                        <?php foreach ($chapter->getLessons() as $lesson): ?>
                        <?php include_partial("detail_courses_lesson", array('course' => $course, 'chapter' => $chapter, 'lesson' => $lesson, 'profile' => $profile)) ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>

     </div>
</li>