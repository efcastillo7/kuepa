<form name="profiles_search_form" action="<?php echo url_for('groups/ProfileSearch') ?>" class="form" onSubmit="return search_profles_list(this)">
  <input type="hidden" name="kind" id="kind" value="<?php echo $kind ?>" />
  <input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id ?>" />
  <div class="row-fluid">
    <div class="span4">
      <input type="text" name="search_text" id="search_text" value="<?php echo $search_text ?>" class="input-medium search-query">
    </div>
    <div class="span2">
      <button type="submit" class="btn">Buscar</button>
    </div>
  </div>
</form>