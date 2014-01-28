<?php use_helper('Groups') ?>
<div class="container">

  <h3>Grupos</h3>
  <a href="<?php echo url_for('groups/new') ?>" class="addGroups-button" level="0">
    Nuevo Grupo
  </a>
  <?php foreach ($groups as $key => $group): ?>
    <?php echo showFullBranch($group); ?>
    <?php // include_partial("group_line",array("group"=>$group)) ?>
  <?php endforeach; ?>
</div>

<!-- Form Add/Edit Group -->
<div class="md-modal" id="form-groups">
  <div class="md-content">
    <h3 id="title"></h3>
    <div>
       <?php include_partial("form") ?>
    </div>
  </div>
</div>


<!-- Form Add/Remove Profiles from groups -->
<div class="md-modal" id="form-profiles">
  <div class="md-content">
    <h3 id="title"></h3>
    <div id="md-subcontent">

    </div>
    <button type="button" class="md-close">Cerrar</button>
  </div>
</div>
  
<script type="text/javascript">
var url_profile_form = "<?php echo url_for('groups/ProfilesForm') ?>";
var url_profile_list = "<?php echo url_for('groups/ProfilesList') ?>";
var url_delete_profile_group = "<?php echo url_for('groups/DeleteProfileGroup') ?>";
var url_subgroup = "<?php echo url_for('groups/getChild') ?>";
var url_remove_group = "<?php echo url_for('groups/DeleteGroup') ?>";
</script>

 <script type="text/javascript" src="/js/uno/groups.js"></script>
