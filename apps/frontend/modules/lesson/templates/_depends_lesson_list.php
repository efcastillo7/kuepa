
 <?php foreach ($lessons as $key => $lesson) { ?>
 <?php
  $q = LessonService::getInstance()->checkLessonOnDependencyPath($course_id, $chapter_id, $lesson_id, $lesson->getId());
  $atrrs = "";
  if ( count($q) > 0 ){
    $atrrs = 'checked="checked" disabled="disabled"';
  } 
 ?>
  <label class="checkbox">
    <input type="checkbox" name="dependency_path[depends_lesson_id][]" value="<?php echo  $lesson->getId(); ?>" <?php echo $atrrs ?> >
    <?php echo "".$lesson->getName() ?>
  </label>
 <?php } ?>