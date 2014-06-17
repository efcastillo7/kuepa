<?php
 $preselected_groups = (isset($preselected_groups) && count($preselected_groups) > 0 ) ? $sf_data->getRaw('preselected_groups') : array();
?>
<ul class="dropdown-menu" role="menu">
	<!-- <li><a href=""><input type="text"></a></li> -->
	<?php foreach ($groups_to_show as $group): 
			$checked = isset($preselected_groups[$category_id]) && in_array($group->getId(), $preselected_groups[$category_id]) ? "checked" : "";
		?>
		<li data-stopPropagation="true">
			<a href="#">
				<input type="checkbox" name="groups[<?php echo $category_id ?>][]" id="groups_<?php echo $group->getId() ?>" value="<?php echo $group->getId() ?>" <?php echo $checked; ?>>
				<?php echo $group->getName() ?>
			</a>
	  </li>
	<?php endforeach ?>
</ul>