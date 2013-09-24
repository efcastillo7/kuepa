<div class="lesson_list" >

    <ul class="unstyled eg-back">
        <li>
            <a href="javascript:void()" class="go-back">
                <span>Atrás</span> <?php echo $chapter->getName() ?>
            </a>
        </li>
    </ul>
    <ul class="unstyled">
        <?php foreach ($lessons as $lesson): ?>
            <?php $current_percentage = ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $lesson->getId()); ?>
        <li>
            <a href="<?php echo url_for("lesson/index?lesson_id=".$lesson->getId()."&chapter_id=".$chapter->getId()."&course_id=".$course->getId()) ?>">
                <div class="lp-node">
                    <div class="lp-bar-prev <?php echo ($previous_percentage!=null&&$previous_percentage==100?"viewed":"") ?>"></div>
                    <div class="lp-bar-post <?php echo ($current_percentage!=null&&$current_percentage==100?"viewed":"") ?>"></div>
                    <span class="lp-node-play"></span>
                    <input class="knob knob-small" value="<?php echo $current_percentage ?>" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                </div>
                <?php echo $lesson->getName() ?>
                <span class="lp-time">10'32''</span>
            </a>
        </li>
            <?php $previous_percentage = $current_percentage; ?>
        <?php endforeach ?>
    </ul>
</div> 