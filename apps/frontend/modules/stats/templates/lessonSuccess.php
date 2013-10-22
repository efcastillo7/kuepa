<h4><?php echo $course->getName() ?> &gt; <?php echo $chapter->getName() ?> &gt; <?php echo $lesson->getName() ?></h4>
<h2>Recursos</h2>

<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Porcentaje de Avance</th>
			<th>Tiempo Dedicado (Minutos)</th>
			<th>Último Recurso Visto</th>
		</tr>
	</thead>
	<?php foreach ($resources as $resource): ?>
		<tr>
			<td><?php echo $resource->getName() ?></td>
			<td><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $resource->getId()) ?> %</td>
			<td><?php echo round($resource->getTotalTime($sf_user->getProfile()->getId())/60) ?></td>
			<td><?php echo $resource->getLastResourceViewed($sf_user->getProfile()->getId())?></td>
		</tr>
	<?php endforeach ?>
</table>