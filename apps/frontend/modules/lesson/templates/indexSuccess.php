<?php use_javascript('uno/lesson.js') ?>

<div id="" class="container">
    <div id="leccion" class="row">
        <div class="span12">
            <p class="gray3"><?php echo $course->getName() ?>  /  <?php echo $chapter->getName() ?></p>
            <p class="title3 clearmargin"><?php echo $lesson->getName() ?></p>
        </div>
    </div>
</div><!-- /container -->

<!-- leccion-camino -->
<div id="" class="learning-path">
    <div id="" class="container">
        <div id="" class="row">
            
            <div class="span3 path-steps">
                <ul class="unstyled gray3">
                    <li class="gray2">- <?php echo $lesson->getName() ?></li>
                    <?php foreach ($lesson->getChildren() as $child): ?>
                        <li class="<?php echo $child->getId() == $resource->getId() ? "active" : "" ?>"><a href="<?php echo url_for("lesson/index?lesson_id=".$lesson->getId()."&chapter_id=".$chapter->getId()."&course_id=".$course->getId()."&resource_id=".$child->getId()) ?>"><?php echo $child->getName() ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="span9">
                <div class="path-content">
                    <p class="title3 white"><?php echo $resource->getName() ?></p>
                    <?php include_partial("views/resources/resource_" . $resource->getRawValue()->getResourceData()->getFirst()->getType(), array('resource' => $resource->getRawValue()->getResourceData()->getFirst())) ?>
                    <div class="txt-right margintop">
                        <?php if($has_next_resource): ?>
                            <a href="<?php echo url_for("lesson/index?lesson_id=".$lesson->getId()."&chapter_id=".$chapter->getId()."&course_id=".$course->getId()."&previous_resource_id=".$resource->getId()) ?>" class="btn btn-large">Siguiente</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /leccion-camino -->

<div id="" class="container margintop40">
    <div id="utilities" class="row">
        <div class="span8">
            <div class="notes">
                <p class="title5">Anotaciones</p>
                <input class="input_add_note span8" type="text" placeholder="Escribe un recordatorio para esta lección..." resource-id="<?php echo $resource->getId() ?>">
                <?php include_partial("views/resource/notes", array('notes' => $notes)) ?>
            </div>
        </div>
        <div class="span3 offset1">
            <div class="share">
                <p class="title5">Compartir</p>
                <a href=""><img src="/img/icn_fb.jpg"></a>
                <a href=""><img src="/img/icn_tw.jpg"></a>
                <a href=""><img src="/img/icn_gp.jpg"></a>
            </div>
            <div class="credits margintop40">
                <p class="title5 clearmargin">Créditos</p>
                <p class="gray3 small1">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>

        </div>
    </div>
</div><!-- /container -->