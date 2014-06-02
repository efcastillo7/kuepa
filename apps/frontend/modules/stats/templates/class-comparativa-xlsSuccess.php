<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<?php 
	$groups = $sf_data->getRaw('groups_ids'); 
	$params = $sf_data->getRaw('params'); 
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th colspan="5">General</th>
			<?php foreach ($course->getChapters() as $chapter): ?>
			<th colspan="2"><?php echo $chapter->getName() ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Progreso</td>
			<td>Tiempo dedicado</td>
			<td>Última Conexión</td>
			<td>Unidades Completadas</td>
			<!-- por unidad -->
			<?php foreach ($course->getChapters() as $chapter): ?>
			<td>Progreso</td>
			<td>Tiempo Dedicado</td>
			<?php endforeach ?>
			<!-- fin por unidad -->
		</tr>
	</thead>
	<tbody>
		<?php foreach ($students as $student): ?>
		<?php $sstatus = isset($status[$student->getId()]) ? $status[$student->getId()][$course->getId()] : 0; ?>
		<tr>
			<td><?php echo $student->getFullName() ?></td>
			<td>
					<?php echo $sstatus?>%</div>	
			</td>
			<td>
				<?php $time_course = isset($courseTimes[$student->getId()]) ? $courseTimes[$student->getId()][$course->getId()] : 0;
				if($time_course > 0):?>
				<?php echo format_time($time_course) ?>
				<?php else: ?>
				-
				<?php endif; ?>
			</td>
			<td>
				<?php if ($student->getLastAccess()): ?>
					<?php echo stdDates::day_diff($student->getLastAccess(),strtotime("now")) ?> dias
				<?php else: ?>
					-
				<?php endif ?>
			</td>
			<td>
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
</body>
</html>