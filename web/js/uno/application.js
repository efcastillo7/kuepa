/***/
function checkAll(obj, selector){
  if(jQuery(obj).is(':checked')) {  
    jQuery(selector).prop('checked',true);
  } else {  
    jQuery(selector).prop('checked',false);
  }  
}