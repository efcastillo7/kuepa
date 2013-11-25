<div id="lv-<?php echo $course->getId() ?>" class="collapse">
    <ul class="lv-lvlone unstyled">
        <?php foreach ($course->getChildren() as $chapter): ?>
            <li>
                <div class="lvl-btn" type="button" data-toggle="collapse" data-target="#lv-<?php echo $course->getId() ?>-<?php echo $chapter->getId() ?>">
                    <div class="lp-node">
                        <div class="lp-bar-prev"></div>
                        <div class="lp-bar-post"></div>
                        <span class="lp-node-play"></span>
                        <input class="knob knob-small" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $chapter->getId()) ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                    </div>
                    <?php echo $chapter->getName() ?>
                    <span class="lp-time"><?php echo $chapter->getDuration() ?></span>
                </div>
                <div id="lv-<?php echo $course->getId() ?>-<?php echo $chapter->getId() ?>" class="collapse">
                    <ul class="lv-lvltwo unstyled">
                        <?php foreach ($chapter->getChildren() as $lesson): ?>
                            <li>
                                <a href="<?php echo url_for("lesson_view?lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId()) ?>">
                                    <div class="lp-node">
                                        <div class="lp-bar-prev"></div>
                                        <div class="lp-bar-post"></div>
                                        <span class="lp-node-play"></span>
                                        <input class="knob knob-small" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $lesson->getId()) ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                                    </div>
                                    <?php echo $lesson->getName() ?>
                                    <span class="lp-time"><?php echo $lesson->getDuration() ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>