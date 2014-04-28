<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
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
	<h3 class="HelveticaLt">Reportes: <span class="HelveticaMd"><?php echo $course->getName() ?></span></h3>

	<div class="container clearpadding menu-list">
		<div class="row">
			<div class="col-xs-7">
			    <div class="dashboard-left">
			        <nav class="nav-dashboard">
			            <ul>
							<li><a href="<?php echo url_for("stats/class?type=lista&course_id=" . $course->getId()) ?>">Lista</a></li>
							<li><a href="<?php echo url_for("stats/class?type=ficha&course_id=" . $course->getId()) ?>">Fichas</a></li>
							<li><a href="<?php echo url_for("stats/class?type=comparativa&course_id=" . $course->getId()) ?>">Comparativa</a></li>
						</ul>
			        </nav>

			        <div class="order">
						<form action="">
							<div class="btn-group">
							<?php foreach($group_categories as $category): ?>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<?php echo $category ?>
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<?php foreach ($category->getGroups() as $group): ?>
									<li><a href="#"><input type="checkbox" name="groups[]" value="<?php echo $group->getId() ?>" <?php echo in_array($group->getId(), $sf_data->getRaw('groups_ids')) ? "checked" : "" ?>> <?php echo $group->getName() ?></a></li>
									<?php endforeach ?>
								</ul>
							</div>
							<?php endforeach; ?>
							<input type="submit" class="btn btn-primary btn-xs" value="Actualizar">
							</div>
						</form>
					</div>
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
					<td colspan="4">General</td>
					<?php foreach ($course->getChapters() as $chapter): ?>
					<td colspan="2" class="bl"><?php echo $chapter->getName() ?></td>
					<?php endforeach ?>
				</tr>
				<tr>
					<td>Progreso</td>
					<td>Tiempo dedicado</td>
					<td>Última Conexión</td>
					<td>Unidades Completadas</td>
					<!-- por unidad -->
					<?php foreach ($course->getChapters() as $chapter): ?>
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
				<?php $sstatus = isset($status[$student->getId()]) ? $status[$student->getId()][$course->getId()] : 0; ?>
				<tr>
					<td>
						<div class="progress">
							<?php if ($sstatus < 35): ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $sstatus?>%;"><?php echo $sstatus?>%</div>	
							<?php elseif ($sstatus < 70): ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $sstatus?>%;"><?php echo $sstatus?>%</div>
							<?php else: ?>
							<div class="progress-bar progress-bar-success" style="width: <?php echo $sstatus?>%;"><?php echo $sstatus?>%</div>
							<?php endif ?>
						</div>
					</td>
					<td>
						<span class="glyphicon glyphicon-time"></span>
						<?php $time_course = isset($courseTimes[$student->getId()]) ? $courseTimes[$student->getId()][$course->getId()] : 0;
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
					<td>
						<span class="glyphicon glyphicon-ok-circle green"></span>
						<?php echo isset($chapterAproved[$student->getId()]) ? $chapterAproved[$student->getId()] : 0; ?>
						/
						<?php echo $course->getChapters()->count() ?>
					</td>

					<!-- por unidad -->
					<?php $get_status = ($time_course > 0); foreach ($course->getChapters() as $chapter):?>
					<td>
						<?php if (!isset($status[$student->getId()]) || !isset($status[$student->getId()][$chapter->getId()])): ?>
						<?php $get_status = false; ?>
						-
						<?php else: ?>
						<?php echo $status[$student->getId()][$chapter->getId()] ?> %
						<?php endif ?>
					</td>
					<td>
						<?php if ($get_status && isset($chapterTimes[$student->getId()][$course->getId()][$chapter->getId()])):?>
						<?php echo format_time($chapterTimes[$student->getId()][$course->getId()][$chapter->getId()]) ?>
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
			  <li><a href="?page=1&count=<?php echo $count_per_page ?>">&laquo;</a></li>
			  <li><a href="?page=<?php echo $pager->getPreviousPage() ?>&count=<?php echo $count_per_page ?>">&laquo;</a></li>
			  <?php foreach ($pager->getLinks() as $page): ?>
			    <?php if ($page == $pager->getPage()): ?>
			      <li class="active"><a href="#"><?php echo $page ?></a></li>
			    <?php else: ?>
			      <li><a href="?page=<?php echo $page ?>&count=<?php echo $count_per_page ?>"><?php echo $page ?></a></li>
			    <?php endif; ?>
			  <?php endforeach; ?>
			  
			  <li><a href="?page=<?php echo $pager->getNextPage() ?>&count=<?php echo $count_per_page ?>">&raquo;</a></li>
			  <li><a href="?page=<?php echo $pager->getLastPage() ?>&count=<?php echo $count_per_page ?>">&raquo;</a></li>
			</ul>


			<div class="btn-group count-results">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
					<?php echo $count_per_page ?>
				<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<?php foreach ($count_per_page_options as $cant): ?>
					<li><a href="?count=<?php echo $cant ?>"><?php echo $cant ?></a></li>
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

<script src="js/dashboard.js"></script>






				