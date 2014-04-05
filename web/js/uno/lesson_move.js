
jQuery(document).ready(function($){

  $('#lesson_origin').cascadingDropdown({
    selectBoxes: [
      {
        selector: '#dependency_path_course_id',
        paramName: 'component_id'
       },
      {
        selector: '#dependency_path_chapter_id',
        requires: ['#dependency_path_course_id'],
        url : url_get_childs,
        paramName: 'component_id',
        textKey : 'name',
        valueKey : 'id'
      },
      {
        selector: '#dependency_path_lesson_id',
        requires: ['#dependency_path_chapter_id'],
        url : url_get_childs,
        paramName: 'component_id',
        textKey : 'name',
        valueKey : 'id',
        onChange: function(event, value) {
          // loadDepencyPathList();
        }
 
      }
    ]
  });

  $('#dependency_tree_form').cascadingDropdown({
    selectBoxes: [
      {
        selector: '#dependency_path_depends_course_id',
        paramName: 'component_id'
        //selected: '5'
      },
      {
        selector: '#dependency_path_depends_chapter_id',
        requires: ['#dependency_path_depends_course_id'],
        url : url_get_childs,
        paramName: 'component_id',
        textKey : 'name',
        valueKey : 'id',
        onChange: function(event, value) {
          // loadDependLessonList();
        }
      }
    ]
  });


  // bind to the form's submit event 
  $('#dependency_tree_form').submit(function() {
      $(this).ajaxSubmit(function(){
        //Reloads the list
        alert('realizado el cambio');
        jQuery("#dependency_path_chapter_id").trigger("change");
      }); 
      return(false);
  });

  // dp_loadDefaults();

});


  function dp_loadDefaults(){
    if ( dp_defaults.course_id != ""){
      setTimeout(function(){ 
        jQuery("#dependency_path_course_id").val(dp_defaults.course_id);
        jQuery("#dependency_path_course_id").trigger("change");            
      },600);

      setTimeout(function(){ 
        jQuery("#dependency_path_chapter_id").val(dp_defaults.chapter_id);
        jQuery("#dependency_path_chapter_id").trigger("change");
      },1800);


    }
  }
