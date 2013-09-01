<div class="unit-view">
        <div id="" class="container margintop60">
            <div id="" class="row">
                <div class="span12">
                    <div class="unit-hd">
                        <div class="lv-icon lvs-biology">
                           <img src="img/subject-icons/subject-icn-biology.png">
                        </div>
                        <p class="title3 HelveticaBd clearmargin"><i class="icon-chevron-right"></i><?php echo $course->getName() ?></p>
                        <p class="small1 HelveticaLt"><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $course->getId()) ?>% Completado</p>
                    </div>
                </div>
                <div class="span12">
                    <div class="unit-container">
                        <p class="gray4">
                            <?php echo $course->getDescription() ?>
                        </p>
                    </div>
                </div>

                <!-- Lista -->
                <div class="span12 margintop">
                    <div class="unit-container">
                        <ul id="myCollapsible" class="lv-container unstyled">
                            <?php foreach ($course->getChapters() as $chapter): ?>
                            <?php include_partial("detail_courses_chapter", array('course' => $course, 'chapter' => $chapter, 'profile' => $profile)) ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- /container -->
    </div>