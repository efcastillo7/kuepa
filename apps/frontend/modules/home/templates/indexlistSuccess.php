<div id="" class="container">
    <div id="productos" class="row">
        <div class="span8 offset1">
            <p class="title3">¡Bienvenido, usuario.alumno!</p>
            <p class="title3 HelveticaLt clearmargin">pregunta.principal</p>
        </div>
        <div class="span2">
            <div class="view-mode">
                <a href="<?php echo url_for("home/index?type=grid") ?>" class="vm-grid" rel="tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modo grilla">Grilla</a>
                <a href="<?php echo url_for("home/index?type=list") ?>" class="vm-list active" rel="tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modo Lista">Lista</a>
            </div>
        </div>

        <!-- Lista -->
        <div class="span10 offset1 margintop">
            <ul id="myCollapsible" class="lv-container unstyled">
                <?php foreach ($courses as $course): ?>
                    <li class="subject-item">
                        <div class="black" type="button" data-toggle="collapse" data-target="#lv-<?php echo $course->getId() ?>">
                            <div class="lv-icon lvs-biology">
                                <img src="<?php echo $course->getThumbnail() ?>">
                            </div>
                            <p class="title3 HelveticaBd clearmargin"><i class="icon-chevron-right"></i><?php echo $course->getName() ?></p>
                            <p class="small1 HelveticaLt"><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $course->getId()) ?>% Completado</p>
                        </div>
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
                                            <span class="lp-time">10'32''</span>
                                        </div>
                                        <div id="lv-<?php echo $course->getId() ?>-<?php echo $chapter->getId() ?>" class="collapse">
                                            <ul class="lv-lvltwo unstyled">
                                                <?php foreach ($chapter->getChildren() as $lesson): ?>
                                                    <li>
                                                        <a href="<?php echo url_for("lesson/index?lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId()) ?>">
                                                            <div class="lp-node">
                                                                <div class="lp-bar-prev"></div>
                                                                <div class="lp-bar-post"></div>
                                                                <span class="lp-node-play"></span>
                                                                <input class="knob knob-small" value="<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $lesson->getId()) ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                                                            </div>
                                                            <?php echo $lesson->getName() ?>
                                                            <span class="lp-time">10'32''</span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>