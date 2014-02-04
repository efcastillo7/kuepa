<?php 
$search_text = (isset( $search_text ) && $search_text != "" ) ? $search_text : '';
$locals = array("kind" => "profiles",
                "group_id" => $group->getId(),
                "search_text" => $search_text);
include_partial('profiles_search_form', $locals);
?>

<form action="<?php echo url_for('groups/AddProfiles') ?>" method="post" onSubmit="return add_profiles(this)">
  <input type="hidden" name="group_id" value="<?php echo $group->getId() ?>">
  <div class="row-fluid">
    <div class="span12" style="height:400px;overflow-y:auto">
      <h5>Listado de Estudiantes</h5>
        <table class="table">
          <tbody>
            <tr>
              <td>
                <input type="checkbox" onClick="checkAll( this,'.checkbox') ">
                Seleccionar Todos
              </td>
            </tr>
            <?php foreach ($profiles as $key => $profile): ?>
            <tr>
              <td>
                  <input type="checkbox" name="profile_ids[]" value="<?php echo $profile->getId(); ?>" class="checkbox">
                  <?php echo mb_substr($profile->getFullName(), 0, 20, 'UTF-8') ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
  </div>

  <div class="row-fluid">
    <div class="span3">
      <button type="submit" class="md-close">Guardar</button>
    </div>
  </div>

</form>