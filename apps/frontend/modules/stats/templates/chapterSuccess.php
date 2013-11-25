<h4><?php echo $course->getName() ?> &gt; <?php echo $chapter->getName() ?></h4>
<h2>Lecciones</h2>

<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Porcentaje de Avance</th>
			<th>Tiempo Dedicado</th>
			<th>Último Recurso Visto</th>
		</tr>
	</thead>
	<?php foreach ($lessons as $lesson): ?>
		<tr>
			<td><a href="<?php echo url_for("stats/lesson?course=" . $course->getId() . "&chapter=" . $chapter->getId() . "&lesson=" . $lesson->getId()) ?>"><?php echo $lesson->getName() ?></a></td>
			<td><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $lesson->getId()) ?> %</td>
			<td><?php echo gmdate("H:i:s", $lesson->getTotalTime($sf_user->getProfile()->getId())) ?></td>
			<td><?php echo $lesson->getLastResourceViewed($sf_user->getProfile()->getId())?></td>
		</tr>
	<?php endforeach ?>
</table>