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

// TODO; Move  the javascript code to a separate file
  jQuery(document).ready(function($){

      // Add Group
      $("body").delegate(".addGroups-button", "click", function(e) {
          fillGroupsForm('','',$(this).attr("level") ,'');
          triggerModalSuccess({id: "form-groups", title: "Crear Grupo", effect: "md-effect-17"});
          return(false);
      });

      // Add SubGroup
      $("body").delegate(".addSubGroups-button", "click", function(e) {
          $wrapper_values = jQuery(this).parent().children('.group-values');
          var group_id = $wrapper_values.children('.group-id').val();
          var group_level = parseInt( $wrapper_values.children('.group-level').val(),10) + 1 ;
          fillGroupsForm('','',group_level ,'');
          $("#groups-form #parent_id").val(group_id);

          triggerModalSuccess({id: "form-groups", title: "Crear SubGrupo", effect: "md-effect-17"});
          return(false);
      });

      // Edit Group
      $("body").delegate(".editGroups-button", "click", function(e) {
          $wrapper_values = jQuery(this).parent().children('.group-values');
          var group_id = $wrapper_values.children('.group-id').val();
          var group_level = $wrapper_values.children('.group-level').val();
          var group_name = $wrapper_values.children('.group-name').val();
          var group_description = $wrapper_values.children('.group-description').val();
          fillGroupsForm(group_id,group_name,group_level ,group_description);
          triggerModalSuccess({id: "form-groups", title: "Editar Grupo", effect: "md-effect-17"});
          return(false);
      });

      // Add Profiles
      $("body").delegate(".addProfiles-button", "click", function(e) {
          $wrapper_values = jQuery(this).parent().children('.group-values');
          var group_id = $wrapper_values.children('.group-id').val();
          triggerModalSuccess({id: "form-profiles", title: "Agregar Estudiantes", effect: "md-effect-17"});
          params = {'group_id' : group_id};
          jQuery.get(url_profile_form, params, function(data){
            jQuery("#form-profiles > .md-content > #md-subcontent").html(data.template);
          },'json');
          return(false);
      });

      // List Profiles
      $("body").delegate(".listProfiles-button", "click", function(e) {
          $wrapper_values = jQuery(this).parent().children('.group-values');
          var group_id = $wrapper_values.children('.group-id').val();
          triggerModalSuccess({id: "form-profiles", title: "Estudiantes", effect: "md-effect-17"});
          params = {'group_id' : group_id};
          jQuery.get(url_profile_list, params, function(data){
            jQuery("#form-profiles > .md-content > #md-subcontent").html(data.template);
          },'json');
          return(false);
      });


      $("body").delegate(".destroyGroup-button", "click", function(e) {
        if ( confirm('Estas seguro que deseas eliminar este grupo y sus sub-grupos') ){
          $group_wrapper = jQuery(this).parent();
          $wrapper_values = $group_wrapper.children('.group-values');
          var group_id = $wrapper_values.children('.group-id').val();
          var params = {'group_id' : group_id};

 
          jQuery.post(url_remove_group, params, function(data){
            // Trick: collapse branch and remove group line
            var link_to_collapse = jQuery("#link_expand_"+group_id);
            link_to_collapse.text("-");
            collapseTree( link_to_collapse[0], group_id);
            $group_wrapper.remove();

           },'json');
         }
      });
      

      tinyMCE.execCommand('mceAddEditor', false, 'groups_description');
  }); 

function fillGroupsForm( id, name, level, description){
  $("#groups-form #groups_id").val( id );
  $("#groups-form #groups_name").val( name );
  $("#groups-form #groups_level").val( level );
  tinyMCE.get('groups_description').setContent( description );
}


// Remover estudiante del grupo
function removeUserFromGroup(group_id, profile_id){
  //url_delete_profile_group
  var params  = {'group_id': group_id, 'profile_id': profile_id };
  jQuery.post(url_delete_profile_group, params, function(data){
    jQuery("#group_profile_"+profile_id).remove();
  });
  return(false);
}



function submitForm(objform){
  $form = jQuery(objform);
  var params = jQuery(objform).serialize();
  var url = $form.attr('url');
  var group = $form.find('#group_id').val();
  jQuery.post(url, params, function(){
    loadProfilesForm();
  });

}

 function collapseTree(objLink, group_id, action){

  if( typeof(action) == 'undefined' ){
    if( jQuery(objLink).html() == "-"){
      jQuery('.parent_'+group_id).hide();
      jQuery(objLink).html("+");
      var action = "collapse";
    }else{
      jQuery('.parent_'+group_id).show();
      jQuery(objLink).html("-");
      var action = "expand";
    }
  }

  jQuery('.parent_'+group_id).each(function(index){
    var $thisobj = jQuery(this);
    var id = $thisobj.prop('id');  // group-@id
    var idspl = id.split("-");
    var sgroup_id = idspl[1];
    var sgroup = jQuery('.parent_'+sgroup_id);

    if( action == "collapse"){
      jQuery('.parent_'+group_id).hide();
    }else{
      jQuery('.parent_'+group_id).show();
    }

    if( sgroup.length > 0 ){
      group = sgroup;
      objLink2 = jQuery("#link_expand_"+sgroup_id)[0];
      collapseTree(objLink2,sgroup_id,action);
    }
    
  }); 
  return(false);
}


</script>

