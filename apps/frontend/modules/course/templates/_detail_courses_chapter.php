<li class="subject-item">
    <a href="#" class="unit-tooltip" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $chapter->getId()) ?>% completado" style="width:<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $chapter->getId()) ?>%;"><div></div></a>
    <div id="<?php echo $chapter->getNameSlug() ?>" class="black" type="button" data-toggle="" data-target="#lv-chapter-<?php echo $chapter->getId() ?>">
        <p class="title5 HelveticaRoman clearmargin"><?php echo $chapter->getName() ?></p>
        <span class="unit-time"><?php echo $chapter->getDuration() ?></span>
     </div>
     <div id="lv-chapter-<?php echo $chapter->getId() ?>" class="">
            <div class="row-fluid">
                <div class="span6">
                    <p class="gray4 italic">
                        <?php echo $chapter->getRaw('description'); ?>
                    </p>
                </div>
                <div class="span6">
                    <ul class="lv-lvlone unstyled">
                        <!-- add lesson if has privilege -->
                        <li chapter="<?php echo $chapter->getId() ?>" class="addlesson-button unsortable">
                            <div class="lvl-btn" type="button">
                                <div class="lp-node">
                                    <div class="lp-bar-prev"></div>
                                    <div class="lp-bar-post"></div>
                                    <span class="lp-node-play"></span>
                                    <input class="knob knob-small" value="0" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                                </div>
                                Agregar Lección
                            </div>
                        </li>
                        <!-- lessons list -->
                        <?php foreach ($chapter->getLessons() as $lesson): ?>
                        <?php include_partial("detail_courses_lesson", array('course' => $course, 'chapter' => $chapter, 'lesson' => $lesson, 'profile' => $profile)) ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>

     </div>
</li>