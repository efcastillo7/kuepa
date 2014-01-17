<section class="data-lesson col-md-9 clearpadding">
  <div class="prev-next">
    <?php if ($has_previous_resource): ?>
        <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getPreviousResourceId()) ?>" class="arrow-hover-left">
          <i class="spr ico-arrow-left10"></i>Anterior
        </a>
    <?php endif; ?>
    <span></span>
    <?php if ($has_next_resource): ?>
    <a href="<?php echo url_for("@lesson_view_resource?course_id=" . $course->getId() . "&chapter_id=" . $chapter->getId() . "&lesson_id=" . $lesson->getId() . "&resource_id=" . $lesson->getNextResourceId()) ?>" class="arrow-hover-right">
      Siguiente<i class="spr ico-arrow-right10"></i>
    </a>
    <?php endif; ?>
  </div>

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