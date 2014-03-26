<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<h2><?php echo $course->getName() ?></h2>

<style>
	table{table-layout: fixed;}
	table td{overflow: hidden;}
	.unit {background-color: gainsboro;}
	.bar { text-align: center}
	.progress { margin-bottom: 0px; }
</style>

<table class="table table-hover">
	<thead>
		<tr>
			<td colspan="2"></td>
			<?php foreach ($students as $student): ?>
			<th><?php echo $student->getFullName() ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Fecha de Primera Conexión</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo utcToLocalDate($student->getFirstAccess(), "dd/M/yyyy H:mm") ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Fecha de Última Conexión</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Tiempo Total Dedicado</td>
			<?php foreach ($students as $student): ?>
			<th>
				<?php if ($student->getTotalTime($sf_data->getRaw('course')) > 0): ?>
					<?php echo gmdate("H:i:s",$student->getTotalTime($sf_data->getRaw('course'))) ?>
				<?php else: ?>
					-
				<?php endif ?>
			</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Promedio de Horas por Semana</td>
			<?php foreach ($students as $student): ?>
			<th> 
				<?php echo gmdate("H:i", $student->getWeekTime($sf_data->getRaw('course'))) ?> hs 
			</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Nota Promedio</td>
			<?php foreach ($students as $student): ?>
			<th>-</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Avance General</td>
			<?php foreach ($students as $student): ?>
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
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th colspan="<?php echo 2+$students->count() ?>"><br> Detalle por Unidad</th>
		</tr>
		<?php foreach ($course->getChapters() as $chapter): ?>
			<tr class="unit">
				<td colspan="2"><b><?php echo $chapter->getName() ?></b></td>
				<?php foreach ($students as $student): ?>
				<td>
					<?php if ($student->getComponentStatus($chapter->getId()) == 100): ?>
						<span class="label label-success"><i class='icon-ok'></i></span>
					<?php endif; ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php foreach ($chapter->getLessons() as $lesson): ?>
			<tr>
				<td></td><td><?php echo $lesson->getName() ?></td>	
				<?php foreach ($students as $student): ?>
				<td>
					<?php if ($student->getComponentStatus($lesson->getId()) == 100): ?>
						<i class='icon-ok'></i>
					<?php elseif($student->getComponentStatus($lesson->getId()) > 0): ?>
						<?php echo $student->getComponentStatus($lesson->getId()) ?> %
					<?php else: ?>
						-
					<?php endif ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php endforeach ?>

		<?php endforeach ?>
	</tbody>
	
</table>
				