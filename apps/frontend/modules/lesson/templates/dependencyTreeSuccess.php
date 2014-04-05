<div class="container">
<?php echo link_to("Listado de Lecciones",'lesson/list') ?> <br><br>
<h3>Dependencia de Lecciones</h3>
<form class="form" id="dependency_tree_form" name="dependency" action="<?php echo url_for('lesson/saveDependency') ?>" method="post">
<div class="row">
  <div class="span4">
    <h5>Leccion :</h5>

      <div class="" id="lesson_origin">
        <label>Curso </label>
         <select name="dependency_path[course_id]" id="dependency_path_course_id">
          <?php foreach ($courses as $key => $c) { ?>
            <option value="<?php echo $c->getId(); ?>"><?php echo $c->getName(); ?></option>
          <?php } ?>
        </select>
        
        <label>Unidad </label>
        <select name="dependency_path[chapter_id]" id="dependency_path_chapter_id">
          <option value="">Seleccionar...</option>
        </select>
       
        <label>Lecci&oacute;n </label>
        <select name="dependency_path[lesson_id]" id="dependency_path_lesson_id">
          <option value="">Seleccionar...</option>
        </select>
      </div>
 </div>

<div class="span4">
  <h5>Depende de : </h5>
  <div class="row">
    <div class="span3">
      <label>Curso </label>
       <select name="dependency_path[depends_course_id]" id="dependency_path_depends_course_id">
        <?php foreach ($courses as $key => $c) { ?>
          <option value="<?php echo $c->getId(); ?>"><?php echo $c->getName(); ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="span4">
        <label>Unidad </label>
        <select name="dependency_path[depends_chapter_id]" id="dependency_path_depends_chapter_id">
          <option value="test">Seleccionar...</option>
        </select>
    </div>
  </div>
</div>
</div>



  <div class="row">
    <div class="span4">
         <h6><b>Dependencias Seleccionadas</b></h6>
        <div id="dependency_path_list">
           Selecciona Curso, Unidad y Lecci&oacute;n...
        </div>
     </div>

    <div class="span4">
        <h5>Seleccion de dependencias</h5>
        <div id="depends_lesson_wrapper">
           Selecciona Curso y Unidad...
          <?php /*include_partial("depends_lesson_list", array('lessons' => $lessons))*/ ?>
        </div>
      <input type="submit" class="btn btn-mini btn-success" value="Agregar" >
     </div>
  </div>

</form>
</div>
<?php use_javascript('libs/jQuery/jquery-cascading-dropdown/jquery.cascadingdropdown.1.2.js') ?>
<script type="text/javascript">
var url_lesson_list = "<?php echo url_for('lesson/getDependsLessonList') ?>";
var url_dependency_path_list = "<?php echo url_for('lesson/DependencyPathList') ?>";
var url_remove_dp = "<?php echo url_for('lesson/DeleteDependency') ?>";
var url_get_childs = '<?php echo url_for("component/getChilds")  ?>';
var dp_defaults = {'course_id' : '<?php echo $course->getId(); ?>',
                'chapter_id' : '<?php echo $chapter->getId(); ?>',
                'lesson_id' : '<?php echo ($lesson) ? $lesson->getId() : ""; ?>'};

</script>
<script type="text/javascript" src="/js/uno/lesson_dependency.js"></script>
