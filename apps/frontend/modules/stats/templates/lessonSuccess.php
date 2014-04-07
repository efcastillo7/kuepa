<style>
	h5 a{
		text-decoration: none;
		color: black;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h5 class="HelveticaLt">
				<a href="<?php echo url_for("stats/course?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a> &gt; 
				<a href="<?php echo url_for("stats/chapter?course=" . $course->getId() . "&chapter=" . $chapter->getId()) ?>"><?php echo $chapter->getName() ?></a> &gt;
				<?php echo $lesson->getName() ?></h5>
			<h3 class="HelveticaLt">Recursos</h3>

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
		</div>
	</div>
</div>
			

