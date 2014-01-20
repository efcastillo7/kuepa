<?php
  $margin_left = 30 * $group->getLevel();
  $css_levels = array('text-success','text-warning','text-error','text-info');
  $parent = $group->getParents();
?>
<div id="group-<?php echo $group->getId(); ?>" class="parent_<?php echo $parent[0] -> getId(); ?>" style="margin-left : <?php echo $margin_left ?>px">
  <div class="group-values">
    <input type="hidden" value="<?php echo $group->getId() ?>" class="group-id">
    <input type="hidden" value="<?php echo $group->getLevel() ?>" class="group-level">
    <input type="hidden" value="<?php echo $group->getName() ?>" class="group-name">
    <input type="hidden" value="<?php echo $group->getDescription() ?>" class="group-description">
   </div>

  <a href="#" id="link_expand_<?php echo $group->getId();?>" 
    onClick="return collapseTree(this, <?php echo $group -> getId() ?>)" 
    class="expand-colapse" title="Ver/Ocultar SubGrupos">-</a>

  <cite title="<?php echo strip_tags( $group->getRaw('description') ) ?>" class="<?php echo $css_levels[ ($group->getLevel()%4) ] ?>"> 
      <b><?php echo $group->getName() ?></b>
  </cite>
  <a class="editGroups-button btn" title="Editar">
    <i class="icon-edit"></i>
  </a>
  <a class="addSubGroups-button btn" title="Crear SubGrupo">
    <i class=" icon-plus-sign"></i>
  </a>
  <a class="addProfiles-button btn" title="Agregar Estudiantes">
      <i class="icon-user"></i>
  </a>
  <a class="listProfiles-button btn" title="Ver Estudiantes">
      <i class="icon-list"></i>
  </a>
  <a class="destroyGroup-button btn" title="Eliminar Grupos/SubGrupos">
      <i class="icon-trash"></i>
  </a>

</div>
