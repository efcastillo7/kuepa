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

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="HelveticaLt"><?php echo $course->getName() ?>
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
			</h3>

			<table class="table table-hover table-responsive">
				<thead>
					<tr>
						<td colspan="5"></td>
						<?php foreach ($course->getChapters() as $chapter): ?>
						<th colspan="2" class="bl bt"><?php echo $chapter->getName() ?></th>
						<?php endforeach ?>
					</tr>
					<tr>
						<th>Nombre alumno</th>
						<th>Progreso</th>
						<th>Tiempo dedicado</th>
						<th>Última Conexión</th>
						<th>Unidades Completadas</th>

						<!-- por unidad -->
						<?php foreach ($course->getChapters() as $chapter): ?>
						<th class="bl">Progreso</th>
						<th>Tiempo Dedicado</th>
						<?php endforeach ?>
						<!-- fin por unidad -->
					</tr>
				</thead>
				<tbody>
					<?php foreach ($students as $student): ?>
					<tr>
						<th><?php echo $student->getFullName() ?></th>
						<td>
							<div class="progress">
								<?php if ($student->getComponentStatus($course->getId()) < 35): ?>
								<div class="bar bar-danger" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>	
								<?php elseif ($student->getComponentStatus($course->getId()) < 70): ?>
								<div class="bar bar-warning" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
								<?php else: ?>
								<div class="bar bar-success" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
								<?php endif ?>
							</div>
						</td>
						<td>
							<?php 
								$time_course = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId()));
							if($time_course == 0):?>
							-
							<?php else: ?>
							<?php echo gmdate("H:i:s", $time_course) ?>
							<?php endif; ?>
						</td>
						<td><?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?></td>
						<td>
							<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedChilds($course->getId(), $student->getId()) ?>
							/
							<?php echo $course->getChapters()->count() ?>
						</td>

						<!-- por unidad -->
						<?php foreach ($course->getChapters() as $chapter): $get_status = ($time_course > 0);?>
						<td class="bl">
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
</div>






				