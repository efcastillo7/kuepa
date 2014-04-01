<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<h2><?php echo $course->getName() ?></h2>

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
				<?php $time = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId()));
				if($time == 0):?>
				-
				<?php else: ?>
				<?php echo gmdate("H:i:s", $time) ?>
				<?php endif; ?>
			</td>
			<td><?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?></td>
			<td>
				<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedChilds($course->getId(), $student->getId()) ?>
				/
				<?php echo $course->getChapters()->count() ?>
			</td>

			<!-- por unidad -->
			<?php foreach ($course->getChapters()	 as $chapter): ?>
			<td class="bl">
				<?php if (!isset($status[$student->getId()]) || !isset($status[$student->getId()][$chapter->getId()])): ?>
				-
				<?php else: ?>
				<?php echo $status[$student->getId()][$chapter->getId()] ?> %
				<?php endif ?>
			</td>
			<td>
				<?php $time = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId(), 'chapter_id' => $chapter->getId())); 
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
				