<div class="row-fluid">
  <div class="span12">
    Filtrar:
    <input type="text" defaultValue="filter" />
  </div>
  <div class="span12" style="height:400px;overflow-y:auto">
    <h5>Estudiantes <?php echo $group->getName(); ?> </h5>
    <table class="table">
      <tbody>
        <?php foreach ($group_profiles as $key => $profile): ?>
        <tr id="group_profile_<?php echo $profile->getId(); ?>">
          <td>
            <a href="#" onClick="return removeUserFromGroup(<?php echo $group->getId(); ?>, <?php echo $profile->getId() ?>)" >
              <i class="icon-remove"></i>
            </a>
          </td>
          <td><?php echo $profile->getFullName(); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>