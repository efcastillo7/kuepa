<?php
function showFullBranch( $group, $branch_content = ""){
  $children = $group->getChildren();
  $branch_content .= get_partial('groups/group_line',array('group'=>$group));
  if ( count( $children) > 0 ){
    foreach ($children as $key => $child) {
      $branch_content = showFullBranch($child, $branch_content);
    }
  }

  return($branch_content);
}
