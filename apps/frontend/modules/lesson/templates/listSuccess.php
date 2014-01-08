<div class="container">
<?php echo link_to("Arbol de Dependencia","lesson/dependencyTree/") ?>
<br>
<table class="table table-striped table-condensed table-hover">
   <thead>
    <tr>
      <td>Id</td>
      <td>Nombre </td>
      <td>Descripcion</td>
      <td>Acciones</td>
    </tr>
  </thead> 
  <tbody>
    <?php foreach ($lessons as $key => $lesson) { ?>
      <tr>
        <td><?php echo $lesson->getId() ?></td>
        <td><?php echo $lesson->getName() ?></td>
        <td><?php echo $lesson->getDescription() ?></td>
        <td><?php echo link_to("Arbol de Dependencia","lesson/dependencyTree?lesson_id=".$lesson->getId()) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

</div>