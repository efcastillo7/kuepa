<h2><?php echo $course->getName() ?></h2>

<table class="table table-hover">
	<thead>
		<tr>
			<td>Estudiantes</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo $student->getFullName() ?></th>
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($course->getChapters() as $chapter): ?>
			<tr>
				<td>Unidad: <?php echo $chapter->getName() ?></td>
				<?php foreach ($students as $student): ?>
				<td> <i class='icon-<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($student->getId(), $chapter->getId()) < 50 ? "remove" : "ok" ?>'></i> <?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($student->getId(), $chapter->getId()) ?> %</td>
				<?php endforeach ?>
			</tr>
			<?php foreach ($chapter->getLessons() as $lesson): ?>
			<tr>
				<td>Lección: <?php echo $lesson->getName() ?></td>	
				<?php foreach ($students as $student): ?>
				<td> <i class='icon-<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($student->getId(), $lesson->getId()) < 50 ? "remove" : "ok" ?>'></i> <?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($student->getId(), $lesson->getId()) ?> %</td>
				<?php endforeach ?>
			</tr>
			<?php endforeach ?>

		<?php endforeach ?>
	</tbody>
	
</table>