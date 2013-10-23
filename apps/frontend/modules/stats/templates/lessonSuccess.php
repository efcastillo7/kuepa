<h4><?php echo $course->getName() ?> &gt; <?php echo $chapter->getName() ?> &gt; <?php echo $lesson->getName() ?></h4>
<h2>Recursos</h2>

<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Porcentaje de Avance</th>
			<th>Tiempo Dedicado</th>
		</tr>
	</thead>
	<?php foreach ($resources as $resource): ?>
		<tr>
			<td><?php echo $resource->getName() ?></td>
			<td><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $resource->getId()) ?> %</td>
			<td><?php echo gmdate("H:i:s", $resource->getTotalTime($sf_user->getProfile()->getId())) ?></td>
		</tr>
	<?php endforeach ?>
</table>