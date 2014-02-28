<?php if ( count($dp_list) > 0 ): ?>
   <?php foreach ($dp_list as $key => $dependency_path): ?>
    <label class="checkbox">
      <a href="#" onClick="return removeDependency(this, <?php echo $dependency_path->getId() ?>)" >
        <i class="icon-trash"></i>
      </a>
       <?php echo Lesson::getRepository()->getById($dependency_path->getDependsLessonId())->getName() ?> 
    </label>
  <?php endforeach; ?>
<?php else: ?>
    No se han seleccionado requisitos aún
<?php endif;?>