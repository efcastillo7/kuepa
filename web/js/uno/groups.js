
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

function search_profles_list(objform){
  $form = jQuery(objform);
  var params = $form.serialize();
  var url = $form.attr("action");
  $(objform).ajaxSubmit({
    'dataType' : 'json',
    success :function(data){
        jQuery("#form-profiles > .md-content > #md-subcontent").html(data.template);
      }
  });
  return(false);
}

/** TODO: AJAX Submit form*/
function add_profiles(objform){
    // submit the form 
  $(objform).ajaxSubmit(function(){
    alert("Almacenado con Exito");
    modalClose( jQuery('#form-profiles') );
  });
  // return false to prevent normal browser submit and page navigation 
  return false; 
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

