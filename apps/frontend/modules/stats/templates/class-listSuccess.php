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
</style>

<!-- //////////// DASHBOARD C REDESIGN /////////////// -->

<div class="tbdata-title-hd none">
	<h3 class="HelveticaLt">Reportes: <span class="HelveticaMd"><?php echo $course->getName() ?></span></h3>
</div>

<div class="tbdata">
	<div id="table-corner" class="tbdata-corner">
		<?php if ($groups->count() > 0): ?>
			<div class="btn-group">
		  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    	<?php if ($group): ?>
					<?php echo $group->getName() ?>
	  		  	<?php else: ?>
					Todos 
				<?php endif; ?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId()) ?>">Todos</a></li>
			    <li class="divider"></li>
				<?php foreach ($groups as $group): ?>
					<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId() ."&group=" . $group->getId()) ?>"><?php echo $group->getName() ?></a></li>
				<?php endforeach ?>
			  </ul>
			</div>
		<?php endif ?>
			<div class="btn-group">
		  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					Todos 
			  </button>
			</div>
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
				<tr>
					<td>
						<div class="progress">
							<?php if ($student->getComponentStatus($course->getId()) < 35): ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>	
							<?php elseif ($student->getComponentStatus($course->getId()) < 70): ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
							<?php else: ?>
							<div class="progress-bar progress-bar-success" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
							<?php endif ?>
						</div>
					</td>
					<td>
						<span class="glyphicon glyphicon-time"></span>
						<?php 
							$time_course = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId()));
						if($time_course == 0):?>
						-
						<?php else: ?>
						<?php echo gmdate("H:i:s", $time_course) ?>
						<?php endif; ?>
					</td>
					<td>
						<span class="glyphicon glyphicon-log-in cyan"></span>
						<?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?>
					</td>
					<td>
						<span class="glyphicon glyphicon-ok-circle green"></span>
						<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedChilds($course->getId(), $student->getId()) ?>
						/
						<?php echo $course->getChapters()->count() ?>
					</td>

					<!-- por unidad -->
					<?php foreach ($course->getChapters() as $chapter): $get_status = ($time_course > 0);?>
					<td>
						<?php if (!isset($status[$student->getId()]) || !isset($status[$student->getId()][$chapter->getId()])): ?>
						<?php $get_status = false; ?>
						-
						<?php else: ?>
						<?php echo $status[$student->getId()][$chapter->getId()] ?> %
						<?php endif ?>
					</td>
					<td>
						<?php if ($get_status){
							$time = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId(), 'chapter_id' => $chapter->getId())); 
						}else{ $time = 0;} ?>
						<?php 
						if($time == 0):?>
						-
						<?php else: ?>
						<?php echo gmdate("H:i:s", $time) ?>
						<?php endif; ?>
					</td>
					<?php endforeach ?>
					<!-- fin por unidad -->
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
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






				