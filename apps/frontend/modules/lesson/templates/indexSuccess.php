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
      <?php $content = $type == "Exercise" ? "exercise" : "resources" ?>
      <?php include_partial("menu_$content", array(
        'course' => $course, 
        'chapter' => $chapter, 
        'lesson' => $lesson, 
        'resource' => $resource, 
        'profile' => $profile)) ?>

      <?php $content = $type == "Exercise" ? "exercise" : "lessons" ?>
      <?php include_partial("content_$content", array(
        'course' => $course, 
        'chapter' => $chapter, 
        'lesson' => $lesson, 
        'resource' => $resource, 
        'profile' => $profile,
        'has_next_resource' => $has_next_resource,
        'has_previous_resource' => $has_previous_resource,
        'is_last_resource' => $is_last_resource,
        'is_first_resource' => $is_first_resource,
        'notes' => $notes,
        'comments' => $comments)) ?>      
    </div>
  </div>
