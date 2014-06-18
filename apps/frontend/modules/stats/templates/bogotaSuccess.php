<h1>Grupos</h1>
<h2>De <?php echo $date_from ?> a <?php echo $date_to ?></h2>

<h3>Por Grupos</h3>
<table class="table">
	<tr>
		<th>Nombre</th>
		<th>Categoria</th>
		<th>Usuarios</th>
		<th>Usuarios Activos</th>
	</tr>

	<?php foreach ($groups as $group): ?>
		<?php 
			$users_in_group = GroupsService::getInstance()->getProfilesInGroupsQuery(array($group->getId()))->count();
			$group_id = $group->getId();
			$active_users = "select count(p.id) as total
				from profile p inner join group_profile gp on gp.profile_id = p.id inner join sf_guard_user sfu on p.sf_guard_user_id = sfu.id inner join sf_guard_user_group sfg on sfu.id = sfg.user_id 
				where   sfg.group_id = 7 and 
						p.id in (select profile_id from log_view_component where created_at > '$date_from' and created_at < '$date_to') and
						gp.group_id = $group_id
				";

			$rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($active_users);
		 ?>
		<tr>
			<td><?php echo $group->getDescription() ?></td>
			<td><?php echo $group->getGroupCategory()->getName() ?></td>
			<td><?php echo $users_in_group ?></td>
			<td><?php echo $rs[0]['total'] ?></td>
		</tr>
	<?php endforeach ?>
</table>

<h3>Perfiles Sin Asignación</h3>
<?php 
	$user_without_data = "select p.*
				from profile p inner join sf_guard_user sfu on p.sf_guard_user_id = sfu.id inner join sf_guard_user_group sfg on sfu.id = sfg.user_id 
				where   sfg.group_id = 7 and 
						p.id in (select profile_id from log_view_component where created_at > '$date_from' and created_at < '$date_to')
						and (institution is null or district is null)
				";
	$rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($user_without_data);
 ?>

 <table class="table">
 	<tr>
 		<td>Id</td>
 		<td>Nombre</td>
 		<td>Localidad</td>
 		<td>Institucion</td>
 		<td>Grupos a los que pertenece</td>
 		<td>Query Fix</td>
 	</tr>

 	<?php foreach ($rs as $profile): ?>
 	<?php 
 		$groups_query = "select g.name as grupo_name, gc.name as category, gc.id as category_id from groups g inner join group_profile gp on g.id = gp.group_id inner join group_category gc on g.group_category_id = gc.id
 			 where gp.profile_id = " . $profile['id'];
 		$groups = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($groups_query);
 	?>
 	<tr>
 		<td><?php echo $profile['id'] ?></td>
 		<td><?php echo $profile['nickname'] ?></td>
 		<td><?php echo $profile['district'] ?></td>
 		<td><?php echo $profile['institution'] ?></td>
 		<?php $district = ""; $college = ""; foreach ($groups as $group): ?>
		<td><?php echo $group['grupo_name'] ?> (<?php echo $group['category'] ?> - <?php echo $group['category_id'] ?>)</td>
		<?php 
			switch ($group['category_id']) {
				case '1':
					$district = $group['grupo_name'];
					break;
				case '2':
					$college = $group['grupo_name'];
				default:
					# code...
					break;
			}
		 ?>
 		<?php endforeach ?>
 		<td>UPDATE profile set district = '<?php echo $district ?>', institution = '<?php echo $college ?>' WHERE id = <?php echo $profile['id'] ?>;</td>
 	</tr>
 	<?php endforeach ?>
 </table>