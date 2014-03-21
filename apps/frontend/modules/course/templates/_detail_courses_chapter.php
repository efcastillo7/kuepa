<li class="subject-item a-son-li" id="<?php echo $chapter->getId() ?>" current_id="<?php echo $chapter->getId()?>">
        <div class="row">
            <div class="col-xs-12">
                <div class="relative">
                    <a href="#" class="unit-tooltip" rel="tooltip" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $chapter->getCacheCompletedStatus(); ?>% completado" style="width:<?php echo $chapter->getCacheCompletedStatus(); ?>%;"><div></div></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="<?php echo $chapter->getNameSlug() ?>" class="black" type="button" data-toggle="" data-target="#lv-chapter-<?php echo $chapter->getId() ?>">
                <div class="col-xs-12 col-md-6">
                    <p class="unit-title">
                        <?php echo $chapter->getName() ?> 
                    </p>
                </div>
                <div class="col-xs-9 col-md-5">
                    <?php if ($sf_user->hasCredential("docente")): ?>
                        <a class="component_set_status btn btn-mini <?php echo $chapter->isEnabled() ? "btn-success" : "btn-danger" ?>" parent_id="<?php echo $course->getId() ?>" child_id="<?php echo $chapter->getId() ?>"><span class="glyphicon glyphicon-off"></span> <span class="text"><?php echo $chapter->isEnabled() ? "Desactivar" : "Activar" ?></span></a>
                        <a class="component_edit_link btn btn-mini" target="modal-create-chapter-form-<?php echo $chapter->getId() ?>"><span class="glyphicon glyphicon-edit"></span> Editar</a>
                        <a class="component_remove_link btn btn-mini" parent_id="<?php echo $course->getId() ?>" child_id="<?php echo $chapter->getId() ?>"><span class="glyphicon glyphicon-trash"></span> Remover</a>
                    <?php endif; ?>
                </div>
                <div class="col-xs-3 col-md-1">
                     <span class="unit-time"><?php echo gmdate("Hº i'",$chapter->getDuration()) ?></span>
                </div>
            </div>
        </div>
        <div class="row margintop">
            <div id="lv-chapter-<?php echo $chapter->getId() ?>">
                <div class="col-xs-12 col-md-6">
                    <p class="gray4 italic">
                        <?php echo $chapter->getRaw('description'); ?>
                    </p>
                </div>
                <div class="col-xs-12 col-md-6">
                    <ul class="lv-lvlone unstyled" current_id="<?php echo $chapter->getId()?>">
                        <?php if ($sf_user->hasCredential("docente")): ?>
                        <!-- add lesson if has privilege -->
                        <div chapter="<?php echo $chapter->getId() ?>" class="addlesson-button unsortable">
                            <div class="lvl-btn HelveticaMd" type="button">
                                <a class="btn btn-mini"><span class="glyphicon glyphicon-plus"></span> Agregar Lección</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- lessons list -->
                        <?php foreach ($chapter->getLessons() as $lesson): ?>
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