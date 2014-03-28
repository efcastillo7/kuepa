<div class="container margintop60">
	<div class="row">
		<div class="col-xs-12">
			<div class="title3 HelveticaLt">Mis cursos</div>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Porcentaje de Avance</th>
							<th>Tiempo Dedicado</th>
						</tr>
					</thead>
					<?php foreach ($courses as $course): ?>
						<tr>
							<td><a href="<?php echo url_for("stats/course?id=" . $course->getId()) ?>"><?php echo $course->getName() ?></a></td>
							<td><?php echo $course->getCacheCompletedStatus(); ?> %</td>
							<td><?php echo gmdate("H:i:s", isset($times[$course->getId()]) ? $times[$course->getId()] : 0) ?></td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
		</div>
	</div>
</div>