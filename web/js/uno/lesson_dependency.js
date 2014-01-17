
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
          loadDepencyPathList();
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
          loadDependLessonList();
        }
      }
    ]
  });


  // bind to the form's submit event 
  $('#dependency_tree_form').submit(function() {
      $(this).ajaxSubmit(function(){
        //Reloads the list
        loadDependLessonList();
        loadDepencyPathList();
      }); 
      return(false);
  });

  dp_loadDefaults();

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

      setTimeout(function(){ 
        jQuery("#dependency_path_lesson_id").val(dp_defaults.lesson_id);
        jQuery("#dependency_path_lesson_id").trigger("change");
      },2700);

    }
  }

  function loadDependLessonList(){
    var depends_course_id = jQuery("#dependency_path_depends_course_id").val();
    var depends_chapter_id = jQuery("#dependency_path_depends_chapter_id").val();

    var course_id = jQuery("#dependency_path_course_id").val();
    var chapter_id = jQuery("#dependency_path_chapter_id").val();
    var lesson_id = jQuery("#dependency_path_lesson_id").val();

    var params = {'course_id' : course_id,
                  'chapter_id' : chapter_id,
                  'lesson_id' : lesson_id,
                  'depends_chapter_id' : depends_chapter_id};
    jQuery.get(url_lesson_list, params ,function(data){
      jQuery("#depends_lesson_wrapper").html(data.template);
    },'json');
  }

  function loadDepencyPathList(){   
    var course_id = jQuery("#dependency_path_course_id").val();
    var chapter_id = jQuery("#dependency_path_chapter_id").val();
    var lesson_id = jQuery("#dependency_path_lesson_id").val();
    var params = { 'course_id' : course_id, 'chapter_id' : chapter_id, 'lesson_id': lesson_id};
    jQuery.get(url_dependency_path_list, params ,function(data){
      jQuery("#dependency_path_list").html(data.template);
      loadDependLessonList();
    },'json');
  }

  function removeDependency(obj, dependency_path_id){
      var params = { 'dependency_path_id' : dependency_path_id};
      jQuery.get(url_remove_dp, params ,function(data){
        jQuery(obj).parent().remove();
        loadDependLessonList();
      },'json');
      return(false);
  }
