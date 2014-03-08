<div class="chapter_list">
    <!-- <ul class="unstyled title">
        <li><?php echo $course->getName() ?></li>
    </ul> -->
    <ul class="unstyled">
        <?php foreach ($chapters as $chapter): ?>
            <?php $current_percentage = $chapter->getCacheCompletedStatus(); ?>
        <li>
            <a href="<?php echo url_for("chapter/expanded?chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId()) ?>" class="remote-link">
                <div class="lp-node">
                    <div class="lp-bar-prev <?php echo ($previous_percentage!=null&&$previous_percentage==100?"viewed":"") ?>"></div>
                    <div class="lp-bar-post <?php echo ($current_percentage!=null&&$current_percentage==100?"viewed":"") ?>"></div>
                    <span class="lp-node-play"></span>
                    <input class="knob knob-small" value="<?php echo $current_percentage ?>" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                </div>
                <?php echo $chapter->getName() ?>
                <span class="lp-time"><?php echo gmdate("Hº i'",$chapter->getDuration()) ?></span>
            </a>
        </li>
            <?php $previous_percentage = $current_percentage; ?>
        <?php endforeach ?>
    </ul>
</div>