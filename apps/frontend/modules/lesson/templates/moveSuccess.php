<div class="container">
<?php echo link_to("Listado de Lecciones",'lesson/list') ?> <br><br>
<h3>Mover Lecciones</h3>
<form class="form" id="dependency_tree_form" name="dependency" action="<?php echo url_for('lesson/saveMove') ?>" method="post">
<div class="row">
  <div class="span4">
    <h5>Leccion Desde:</h5>

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
  <h5>Unidad Hasta : </h5>
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
        </select><br>
        <input type="submit" class="btn btn-mini btn-success" value="Mover" >
    </div>
  </div>
</div>
</div>


</form>
</div>
<?php use_javascript('libs/jQuery/jquery-cascading-dropdown/jquery.cascadingdropdown.1.2.js') ?>
<script type="text/javascript">
var url_get_childs = '<?php echo url_for("component/getChilds")  ?>';
var dp_defaults = {'course_id' : '<?php echo $course->getId(); ?>',
                'chapter_id' : '<?php echo $chapter->getId(); ?>',
                'lesson_id' : '<?php echo ($lesson) ? $lesson->getId() : ""; ?>'};
</script>
<script type="text/javascript" src="/js/uno/lesson_move.js"></script>
