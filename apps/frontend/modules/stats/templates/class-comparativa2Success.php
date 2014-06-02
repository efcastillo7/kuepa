<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<?php 
	$groups = $sf_data->getRaw('groups_ids'); 
	$params = $sf_data->getRaw('params'); 
?>
<style>
	/*table{table-layout: fixed;}*/
	/*table td{overflow: hidden;}*/
	.unit {background-color: gainsboro;}
	.bar { text-align: center}
	.progress { margin-bottom: 0px; }
	table td{ min-width: 100px;}
	.bl { border-left: 1px solid #ddd;}
	.br { border-right: 1px solid #ddd;}
	.bt { border-top: 1px solid #ddd !important;}
	.menu-list{
		position: absolute;
		left: 30px;
		top: 55px;
	}
	.count-results{
		position: relative;
		top: -33px;
		left: 10px;
	}
</style>

<!-- //////////// DASHBOARD C REDESIGN /////////////// -->

<div class="tbdata-title-hd">
	<h3 class="HelveticaLt">Reportes: <span class="HelveticaMd">Cursos</span></h3>

	<div class="container clearpadding menu-list">
		<div class="row">
			<div class="col-xs-7">
			    <div class="dashboard-left">
					<?php if(count($group_categories)): ?>
			        <div class="order">
						<form action="" id="form_categories">
							<div class="btn-group">
							<?php foreach($group_categories as $category): ?>
							<div class="btn-group <?php echo strtolower($category) ?>">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<?php echo $category ?>
									<span class="caret"></span>
								</button>
								<?php
									$c_id = $category->getId();
									$filters = ( $c_id == 2 && isset( $groups[1] ) ) ? $groups[1] : array();
									$groups_to_show = $category->getCategoryGroups($filters);
									include_partial('groups_category', array('groups_to_show' => $groups_to_show, 'preselected_groups' => $groups, 'category_id' => $c_id )); 
								?>
							</div>
							<?php endforeach; ?>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									Nombre
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li data-stopPropagation="true">
										<a href="#">
											<input type="text" name="data[name]" id="" value="<?php echo isset($text_filters['name']) ? $text_filters['name'] : "" ?>">
										</a>
								    </li>
								</ul>
							</div>
							<input type="submit" class="btn btn-primary btn-xs" value="Actualizar">
							</div>
						</form>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="tbdata">
	<div id="table-corner" class="tbdata-corner">
		
	</div>
	<div id="table-hd" class="tbdata-hd">
		<table class="table table-hover">
			<thead>
				<tr>
					<td colspan="2">General</td>
					<?php foreach ($courses as $course): ?>
					<td colspan="2" class="bl"><?php echo $course->getName() ?></td>
					<?php endforeach ?>
				</tr>
				<tr>
					<td>Tiempo dedicado</td>
					<td>Última Conexión</td>
					<!-- por unidad -->
					<?php foreach ($courses as $course): ?>
					<td class="bl">Progreso</td>
					<td>Tiempo Dedicado</td>
					<?php endforeach ?>
					<!-- fin por unidad -->
				</tr>
			</thead>
		</table>
	</div>
	<div id="table-left" class="tbdata-left">
		<table class="table table-hover">
			<tbody>
				<?php foreach ($students as $student): ?>
				<tr><td class="td-first"><?php echo $student->getFullName() ?></td></tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<div class="tbdata-info">
		<table class="table table-hover table-bordered">
			<tbody>
				<?php foreach ($students as $student): ?>
				<tr>
					<td>
						<span class="glyphicon glyphicon-time"></span>
						<?php $time_course = isset($profileTimes[$student->getId()]) ? $profileTimes[$student->getId()] : 0;
						if($time_course > 0):?>
						<?php echo format_time($time_course) ?>
						<?php else: ?>
						-
						<?php endif; ?>
					</td>
					<td>
						<span class="glyphicon glyphicon-log-in cyan"></span>
						<?php if ($student->getLastAccess()): ?>
							<?php echo stdDates::day_diff($student->getLastAccess(),strtotime("now")) ?> dias
						<?php else: ?>
							-
						<?php endif ?>
					</td>

					<!-- por curso -->
					<?php $get_status = ($time_course > 0); foreach ($courses as $course): ?>
					<td>
						<?php if (!isset($status[$student->getId()]) || !isset($status[$student->getId()][$course->getId()]) || !isset($courseTimes[$student->getId()][$course->getId()]) || $courseTimes[$student->getId()][$course->getId()] == 0): ?>
						-
						<?php else: $sstatus = $status[$student->getId()][$course->getId()];?>
						<div class="progress">
							<?php if ($sstatus < 35): ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $sstatus?>%;"><?php echo $sstatus?>%</div>	
							<?php elseif ($sstatus < 70): ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $sstatus?>%;"><?php echo $sstatus?>%</div>
							<?php else: ?>
							<div class="progress-bar progress-bar-success" style="width: <?php echo $sstatus?>%;"><?php echo $sstatus?>%</div>
							<?php endif ?>
						</div>
						<?php endif ?>
					</td>
					<td>
						<?php if ($get_status && isset($courseTimes[$student->getId()][$course->getId()]) && $courseTimes[$student->getId()][$course->getId()] > 0):?>
						<?php echo format_time($courseTimes[$student->getId()][$course->getId()]) ?>
						<?php else: ?>
						-
						<?php endif; ?>
					</td>
					<?php endforeach ?>
					<!-- fin por unidad -->
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php if ($pager->haveToPaginate()): ?>
			<ul class="pagination">
			  <li><a href="?page=1&<?php echo http_build_query($params) ?>">&laquo;</a></li>
			  <li><a href="?page=<?php echo $pager->getPreviousPage() ?>&<?php echo http_build_query($params) ?>">&laquo;</a></li>
			  <?php foreach ($pager->getLinks() as $page): ?>
			    <?php if ($page == $pager->getPage()): ?>
			      <li class="active"><a href="#"><?php echo $page ?></a></li>
			    <?php else: ?>
			      <li><a href="?page=<?php echo $page ?>&<?php echo http_build_query($params) ?>"><?php echo $page ?></a></li>
			    <?php endif; ?>
			  <?php endforeach; ?>
			  
			  <li><a href="?page=<?php echo $pager->getNextPage() ?>&<?php echo http_build_query($params) ?>">&raquo;</a></li>
			  <li><a href="?page=<?php echo $pager->getLastPage() ?>&<?php echo http_build_query($params) ?>">&raquo;</a></li>
			</ul>


			<div class="btn-group count-results">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
					<?php echo $count_per_page ?>
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<?php foreach ($count_per_page_options as $cant): ?>
					<li><a href="?count=<?php echo $cant ?>&<?php echo http_build_query(array('groups' => $params['groups'])) ?>"><?php echo $cant ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>

			<div class="pagination_desc">
			  Página <span class="badge"><?php echo $pager->getPage() ?></span> de <span class="badge"><?php echo $pager->getLastPage() ?></span>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>



<script>
	$(window).scroll(function(){
	    $('#table-left').css({
	        'left': $(this).scrollLeft() //Use it later
	    });
	    $('#table-hd').css({
	        'top': $(this).scrollTop() - 100 //Use it later
	    });
	    
	});

</script>

<script src="/js/dashboard.js"></script>






				