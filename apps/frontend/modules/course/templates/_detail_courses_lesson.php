<li class="a-son-li" current_id="<?php echo $lesson->getId()?>">
    <div class="lvl-btn" type="button" data-toggle="collapse" data-target="#lv-lesson-<?php echo $lesson->getId()?>">
        <div class="lp-node">
            <div class="lp-bar-prev"></div>
            <div class="lp-bar-post"></div>
            <span class="lp-node-play"></span>
            <input class="knob knob-small" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $lesson->getId()) ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
        </div>
        <?php echo $lesson->getName() ?> - <a class="component_edit_link" target="modal-create-lesson-form-<?php echo $lesson->getId() ?>">Editar</a>
        <span class="lp-time"><?php echo $lesson->getDuration() ?></span>
    </div>
    <div id="lv-lesson-<?php echo $lesson->getId()?>" class="collapse">
        <ul class="lv-lvltwo unstyled" current_id="<?php echo $lesson->getId()?>">
            <!-- Add resource -->
            <li lesson="<?php echo $lesson->getId() ?>" class="addresource-button unsortable">
                <div class="lp-node">
                    <div class="lp-bar-prev"></div>
                    <div class="lp-bar-post"></div>
                    <span class="lp-node-play"></span>
                    <input class="knob knob-small" value="0" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                </div>
                Agregar Recurso
            </li>

            <!-- resources list -->
            <?php foreach ($lesson->getResources() as $resource): ?>
            <?php include_partial("detail_courses_resource", array('course' => $course, 'chapter' => $chapter, 'lesson' => $lesson, 'resource' => $resource, 'profile' => $profile)) ?>    
            <?php endforeach ?>
        </ul>
    </div>
</li>
<?php include_component('lesson', 'Modalform', array('chapter_id' => $chapter->getId(), 'id' => $lesson->getId())) ?>