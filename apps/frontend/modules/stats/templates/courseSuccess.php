<h4><?php echo $course->getName() ?></h4>
<h2>Unidades</h2>

<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Porcentaje de Avance</th>
			<th>Tiempo Dedicado</th>
			<th>Duración de la lección</th>
			<th>Último Recurso Visto</th>
		</tr>
	</thead>
	<?php foreach ($chapters as $chapter): ?>
		<tr>
			<td><a href="<?php echo url_for("stats/chapter?course=" . $course->getId() . "&chapter=" . $chapter->getId()) ?>"><?php echo $chapter->getName() ?></a></td>
			<td><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $chapter->getId()) ?> %</td>
			<td><?php echo gmdate("H:i:s", $chapter->getTotalTime($sf_user->getProfile()->getId())) ?></td>
			<td><?php echo gmdate("H:i:s", $chapter->getDuration()) ?></td>
			<td><?php echo $chapter->getLastResourceViewed($sf_user->getProfile()->getId())?></td>
		</tr>
	<?php endforeach ?>
</table>