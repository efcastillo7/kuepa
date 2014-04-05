<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h5 class="HelveticaLt"><?php echo $course->getName() ?></h5>
			<h3 class="HelveticaLt">Unidades</h3>
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
						<td><?php echo $chapter->getCacheCompletedStatus();  ?> %</td>
						<td><?php echo gmdate("H:i:s", LogService::getInstance()->getTotalTimeByRoute($sf_user->getProfile()->getId(), array('course_id' => $course->getId(), 'chapter_id' => $chapter->getId()))) ?></td>
						<td><?php echo gmdate("H:i:s", $chapter->getDuration()) ?></td>
						<td><?php echo $chapter->getLastResourceViewed($sf_user->getProfile()->getId())?></td>
					</tr>
				<?php endforeach ?>
			</table>

		</div>
	</div>
</div>