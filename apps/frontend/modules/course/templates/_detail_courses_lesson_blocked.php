<li class="a-son-li" current_id="<?php echo $lesson->getId()?>">
    <div class="lvl-btn" type="button" data-toggle="collapse" data-target="#lv-lesson-<?php echo $lesson->getId()?>">
        <div class="lp-node">
            <div class="lp-bar-prev"></div>
            <div class="lp-bar-post"></div>
            <span class="lp-node-play"></span>
            <input class="knob knob-small" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $lesson->getId()) ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
        </div>
        <?php echo $lesson->getName() ?> 
    </div>
    <div id="lv-lesson-<?php echo $lesson->getId()?>" class="collapse">
        <p class="gray4 italic">Contenido bloqueado por el docente.</p>
    </div>
</li>
<?php if ($sf_user->hasCredential("docente")): ?>
<?php include_component('lesson', 'Modalform', array('chapter_id' => $chapter->getId(), 'id' => $lesson->getId())) ?>
<?php endif; ?>