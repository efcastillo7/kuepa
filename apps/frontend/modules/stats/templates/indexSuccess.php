<h2>Mis cursos</h2>

<table class="table">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Porcentaje de Avance</th>
			<th>Tiempo Dedicado</th>
			<th>Último Recurso Visto</th>
		</tr>
	</thead>
	<?php foreach ($courses as $course): ?>
		<tr>
			<td><a href="<?php echo url_for("stats/course?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a></td>
			<td><?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($sf_user->getProfile()->getId(), $course->getId()) ?> %</td>
			<td><?php echo gmdate("H:i:s", $course->getTotalTime($sf_user->getProfile()->getId())) ?></td>
			<td><?php echo $course->getLastResourceViewed($sf_user->getProfile()->getId())?></td>
		</tr>
	<?php endforeach ?>
</table>