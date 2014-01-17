<form action="/groups/create" method="POST" id="groups-form">
  <input type="hidden" name="parent_id" id="parent_id" value=""/>
  <input type="hidden" name="groups[id]" id="groups_id" value=""/>
  <input type="hidden" name="groups[level]" id="groups_level" value=""/>
  <label for="groups_name">Nombre</label></th>
  <input type="text" name="groups[name]" id="groups_name" />
  <label for="groups_description">Description</label>
  <textarea name="groups[description]" id="groups_description"></textarea>
  <div class="row-fluid">
    <div class="span3">
      <button type="submit" class="btn">Guardar</button>
    </div>
    <div class="span3">
      <button type="button" class="md-close">Cerrar</button>
    </div>
  </div>
</form>
