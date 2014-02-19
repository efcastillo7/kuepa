<li class="subject-item a-son-li" id="<?php echo $chapter->getId() ?>" current_id="<?php echo $chapter->getId()?>">
    <a href="#" class="unit-tooltip" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $chapter->getId()) ?>% completado" style="width:<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $chapter->getId()) ?>%;"><div></div></a>
    <div id="<?php echo $chapter->getNameSlug() ?>" class="black" type="button" data-toggle="" data-target="#lv-chapter-<?php echo $chapter->getId() ?>">
        <p class="title5 HelveticaRoman clearmargin">
            <?php echo $chapter->getName() ?> 
            <?php if ($sf_user->hasCredential("docente")): ?>
            <a class="component_set_status btn btn-mini <?php echo $chapter->isEnabled() ? "btn-success" : "btn-danger" ?>" parent_id="<?php echo $course->getId() ?>" child_id="<?php echo $chapter->getId() ?>"><?php echo $chapter->isEnabled() ? "Desactivar" : "Activar" ?></a>
            <a class="component_edit_link btn btn-mini" target="modal-create-chapter-form-<?php echo $chapter->getId() ?>">Editar</a>
            <a class="component_remove_link btn btn-mini" parent_id="<?php echo $course->getId() ?>" child_id="<?php echo $chapter->getId() ?>">Remover</a>
            <?php endif; ?>
        </p>
        <span class="unit-time"><?php echo gmdate("Hº i'",$chapter->getDuration()) ?></span>
     </div>
     <div id="lv-chapter-<?php echo $chapter->getId() ?>" class="">
            <div class="row-fluid">
                <div class="span6">
                    <p class="gray4 italic">
                        <?php echo $chapter->getRaw('description'); ?>
                    </p>
                </div>
                <div class="span6">
                    <ul class="lv-lvlone unstyled" current_id="<?php echo $chapter->getId()?>">
                        <?php if ($sf_user->hasCredential("docente")): ?>
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
                        <?php endif; ?>
                        <!-- lessons list -->
                        <?php foreach ($chapter->getLesson() as $lesson): ?>
                            <?php if($sf_user->hasCredential("estudiante") && !$lesson->isEnabled()): ?>
                            <?php include_partial("detail_courses_lesson_blocked", array('course' => $course, 'chapter' => $chapter, 'lesson' => $lesson, 'profile' => $profile)) ?>
                            <?php else: ?>
                            <?php include_partial("detail_courses_lesson", array('course' => $course, 'chapter' => $chapter, 'lesson' => $lesson, 'profile' => $profile)) ?>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>

     </div>
</li>
<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('chapter', 'Modalform', array('course_id' => $course->getId(), 'id' => $chapter->getId())) ?>
<?php endif; ?>