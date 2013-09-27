<li class="a-son-li" current_id="<?php echo $resource->getId()?>">
    <div class="lp-node">
        <div class="lp-bar-prev"></div>
        <div class="lp-bar-post"></div>
        <span class="lp-node-play"></span>
        <input class="knob knob-small" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $resource->getId()) ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
    </div>
    <a href="<?php echo url_for("@lesson_view_resource?lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId() . "&resource_id=" . $resource->getId()) ?>">
    	<?php echo $resource->getName() ?>
        <?php if ($sf_user->hasCredential("docente")): ?>
        - <a class="component_remove_link" parent_id="<?php echo $lesson->getId() ?>" child_id="<?php echo $resource->getId() ?>">Remover</a>
        <?php endif; ?>
	</a>
    <span class="lp-time"><?php echo $resource->getDuration() ?></span>
</li>