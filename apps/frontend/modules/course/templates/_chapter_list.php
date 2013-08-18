<div class="chapter_list">
    <ul class="unstyled title">
        <li><?php echo $course->getName() ?></li>
    </ul>
    <ul class="unstyled">
        <?php foreach ($chapters as $chapter): ?>
        <li>
            <a href="<?php echo url_for("chapter/expanded?chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId()) ?>" class="remote-link">
                <div class="lp-node">
                    <div class="lp-bar-prev"></div>
                    <div class="lp-bar-post viewed"></div>
                    <span class="lp-node-play"></span>
                    <input class="knob knob-small" value="90" data-fgColor="#fff" data-bgColor="#000" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                </div>
                <?php echo $chapter->getName() ?>
                <span class="lp-time">10'32''</span>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div>