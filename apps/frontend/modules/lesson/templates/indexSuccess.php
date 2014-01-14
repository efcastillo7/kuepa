<script>
    var course_id = <?php echo $course->getId() ?>;
    var chapter_id = <?php echo $chapter->getId() ?>;
    var lesson_id = <?php echo $lesson->getId() ?>;
    var resource_id = <?php echo $resource->getId() ?>;
</script>
<?php use_javascript('uno/lesson.js') ?>

  <section class="container clearpadding">
    <section class="breadcrum">
      <div class="icon eg-thumb bg-<?php echo $course->getColor()?>-alt-1">
        <img src="<?php echo $course->getThumbnailPath() ?>">
      </div>

      <a class="link-grey" href="<?php echo url_for("course/details?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a>
      <i class="spr ico-arrow-breadcrum"></i>

      <a class="link-grey" href="<?php echo url_for("course/details?id=" . $course->getId()) ?>#<?php echo $chapter->getNameSlug() ?>"><?php echo $chapter->getName() ?></a>
      <i class="spr ico-arrow-breadcrum"></i>

      <a class="link-grey" href="<?php echo url_for("course/details?id=" . $course->getId()) ?>#<?php echo $chapter->getNameSlug() ?>"><?php echo $lesson->getName() ?></a>
      <i class="spr ico-arrow-breadcrum"></i>

      <a href="#" class="link-white"><?php echo $resource->getName() ?></a>
    </section>
  </section>

  <div class="container">
    <div class="row">

      <section class="wrapper-aside-lesson col-md-3 clearpadding">
        <aside class="aside-lesson">
          <div class="header-lesson">
            <a href="#">
              <i class="spr ico-arrow-left10"></i>
              Lecciones
            </a>
            <span></span>
          </div>

          <ul class="list-aside-lesson">
            <li class="head-list">
              <h3><?php echo $lesson->getName() ?></h3>
              <h4><?php echo $lesson->getChildren()->count() ?> recursos, <?php echo round($lesson->getDuration()/60,2) ?> minutos</h4>
            </li>
            <?php foreach ($lesson->getChildren() as $child): ?>
                <?php $current_percentage = ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile->getId(), $child->getId()) ?>
                <li>
                  <div class="icon">
                    <?php if($current_percentage == 100): ?>
                    <div class="back-full"></div>
                    <div class="spr ico-full"></div>
                    <?php else: ?>
                    <div class="spr ico-triangle-gray"></div>
                    <?php endif; ?>

                    <div class="lp-node">
                      <div class="lp-bar-prev <?php echo ($previous_percentage!=null && $previous_percentage==100? "full":"") ?>"></div>
                      <div class="lp-bar-post <?php echo ($current_percentage!=null && $current_percentage==100?"full":"") ?>"></div>
                      <span class="lp-node-play"></span>
                      <input class="knob" value="<?php echo $current_percentage ?>" data-fgColor="#ff671b" data-bgColor="#c7c7cc" data-width="28" data-height="28" data-thickness=".28" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
                    </div>
                  </div>
                  <a class="<?php echo $child->getId() == $resource->getId() ? "orange" : "" ?>" href="<?php echo url_for("@lesson_view_resource?lesson_id=" . $lesson->getId() . "&chapter_id=" . $chapter->getId() . "&course_id=" . $course->getId() . "&resource_id=" . $child->getId()) ?>"><?php echo $child->getName() ?></a>
                </li>
                <?php $previous_percentage = $current_percentage; ?>
            <?php endforeach; ?>
          </ul>
        </aside>
      </section>

      <section class="data-lesson col-md-9 clearpadding">

        <h1>
          <?php echo $resource->getName() ?>
          <div class="prev-next">
            <?php if ($has_previous_resource): ?>
                <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getPreviousResourceId()) ?>"><i class="spr ico-arrow-left10"></i>Anterior</a>
            <?php endif; ?>
            <?php if ($has_next_resource): ?>
            <span></span>
            <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getNextResourceId()) ?>">Siguiente<i class="spr ico-arrow-right10"></i></a>
            <?php endif; ?>
          </div>
        </h1>

        <div class="content">
        <?php if ($resource->getDescription() != ""): ?>
            <h2><?php echo $resource->getRaw('description') ?></h2>
        <?php endif; ?>

        <?php include_partial("views/resources/resource_" . $resource->getRawValue()->getResourceData()->getFirst()->getType(), array('resource' => $resource->getRawValue()->getResourceData()->getFirst())) ?>

        <?php if ($has_next_resource): ?>
        <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getNextResourceId()) ?>" class="btn btn-primary btn-orange">Siguiente</a>
        <?php endif; ?>
        <div class="clear"></div>
      </div>

        <div class="separator margintop"></div>

        <div class="content annotations">
          <h3 class="with-icon">
            <div class="wrap wrap-square wrap-blue">
              <i class="spr ico-annotations"></i>
            </div>
            Anotaciones
          </h3>

          <div class="input-append-pos">
            <div class="cont-inputs">
             <input class="input_add_note input-send-message span7" type="text" placeholder="Escribe un recordatorio para esta lección" resource-id="<?php echo $resource->getId() ?>" privacy="private" >
              <button type="button" class="btn-inside btn-gray-light">Aceptar</button>
            </div>
          </div>

          <div class="separator margintop"></div>
          <?php include_partial("views/resource/notes", array('notes' => $notes)) ?>
        </div><!-- content -->

      </section>

    </div>
  </div>