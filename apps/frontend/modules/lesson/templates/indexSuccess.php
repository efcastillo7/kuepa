<?php use_javascript('uno/lesson.js') ?>

<div id="" class="container">
    <div id="leccion" class="row">
        <div class="span8">
            <p class="gray3"><a href="<?php echo url_for("course/details?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a> /  <a href="<?php echo url_for("course/details?id=" . $course->getId()) ?>#<?php echo $chapter->getNameSlug() ?>"><?php echo $chapter->getName() ?></a></p>
            <p class="title3 clearmargin"><?php echo $lesson->getName() ?></p>
        </div>
        <div class="span4">
            <div class="txt-right margintop">
                <?php if ($has_previous_lesson): ?>
                    <a href="<?php echo url_for("lesson/index?following_lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId()) ?>" class="btn btn-mini">
                        &lt; Lección Anterior
                    </a>
                <?php endif; ?>
                <?php if ($has_next_lesson): ?>
                    <a href="<?php echo url_for("lesson/index?previous_lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId()) ?>" class="btn btn-mini btn-primary">
                        Siguiente Lección &gt;
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><!-- /container -->

<!-- leccion-camino -->
<div id="" class="learning-path">
    <div id="" class="container">
        <div id="" class="row">
            <div class="span3 path-steps">
                <ul class="unstyled gray3">
                    <!-- <li class="gray2">- <?php echo $lesson->getName() ?></li> -->
                    <?php foreach ($lesson->getChildren() as $child): ?>
                        <li class="<?php echo $child->getId() == $resource->getId() ? "active" : "" ?>"><a href="<?php echo url_for("@lesson_view_resource?lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId() . "&resource_id=" . $child->getId()) ?>"><?php echo $child->getName() ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="span9">
                <div class="path-content resource">
                    <p class="title3 white"><?php echo $resource->getName() ?></p>
                    <?php if ($resource->getDescription() != ""): ?>
                        <p><?php echo $resource->getRaw('description') ?></p>
                    <?php endif; ?>
                    <?php include_partial("views/resources/resource_" . $resource->getRawValue()->getResourceData()->getFirst()->getType(), array('resource' => $resource->getRawValue()->getResourceData()->getFirst())) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span2 offset10 text-right marginbottom20">
                <?php if ($has_previous_resource): ?>
                    <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getPreviousResourceId()) ?>" class="btn btn-mini">
                        &lt; Volver</a>
                <?php endif; ?>
                <?php if ($has_next_resource): ?>
                    <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getNextResourceId()) ?> " class="btn btn-mini btn-primary">
                        Seguir &gt;</a>
                <?php endif; ?>
                <?php if ($is_last_resource): ?>
                    <a href="<?php echo url_for("course/details?id=" . $course->getId()) ?>#<?php echo $chapter->getNameSlug() ?>" class="btn btn-mini btn-primary">
                        Volver al Curso &gt;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><!-- /leccion-camino -->

<div id="" class="container margintop40">
    <div id="utilities" class="row">

        <div class="span8">
            <div class="notes">
                <div id="tabs">
                  <ul>
                    <li><a class="title5" href="#tabs-annotations">Mis Anotaciones</a></li>
                    <!-- <li><a class="title5" href="#tabs-grupal-annotations">Anotaciones Grupales</a></li> -->
                  </ul>
                  <div id="tabs-annotations">
                    <input class="input_add_note span7" type="text" placeholder="Escribe un recordatorio para esta lección..." resource-id="<?php echo $resource->getId() ?>">
                    <?php include_partial("views/resource/notes", array('notes' => $notes)) ?>
                  </div>
                  <!-- <div id="tabs-grupal-annotations">
                    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
                  </div> -->
                </div>                
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