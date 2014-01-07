<h1><?php echo $course->getName() ?></h1>

<h3>Avance</h3>
<?php if($has_stats): ?>
<div class="row">
	<div class="span8">
		<?php include_component('stats', 'burndownChartWeeks', array('course_id' => $course->getId())) ?>
	</div>
	<div class="span4">
		<h4>Estadísticas</h4>
		<table class="table">
			<tr>
				<th>Duración del Curso</th>
				<td><?php echo round($stats['course_duration']) ?> hs</td>
			</tr>
			<tr>
				<th>Horas Dedicadas</th>
				<td><?php echo $stats['hs_dedicated'] ?> hs</td>
			</tr>
			<tr>
				<th>Dias Transcurridos</th>
				<td><?php echo $stats['days_lapse'] ?></td>
			</tr>
			<tr>
				<th>Promedio Dedicado Semanal</th>
				<td><?php echo $stats['weeks_lapse'] > 0 ? $stats['hs_dedicated']/$stats['weeks_lapse'] : 0 ?> hs</td>
			</tr>
			<tr>
				<th>Dias para Finalizar</th>
				<td><?php echo $stats['days_remaining'] ?></td>
			</tr>
			<tr>
				<th>Horas Restantes</th>
				<td><?php echo $stats['hs_remaining'] ?> hs</td>
			</tr>
			<tr>
				<th>Esfuerzo Semanal para Finalizar en Fecha</th>
				<td><?php echo $stats['weeks_remaining'] > 1 ? round($stats['hs_remaining']/$stats['weeks_remaining']) : $stats['hs_remaining'] ?> hs</td>
			</tr>
		</table>
	</div>
</div>
<?php else: ?>
	<div class="alert alert-block alert-info">
	  <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
	  <?php if ($seted_deadline): ?>
	  Todavía no has accedido al curso.
	  <?php else: ?>
	  Todavía no has definido una fecha límite. <a href="#" class="btn btn-inverse" id="setdeadline">Definir Fecha</a><div id="datepicker"></div>
	  <?php endif ?>
	</div>

	<script>
		$("#setdeadline").click(function(){
			$( "#datepicker" ).datepicker({
				dateFormat: "yy-mm-dd",
				minDate: new Date(),
				onSelect: function(date){
					$.ajax({
						url: "/kuepa_api_dev.php/course/deadline",
						data: {course_id: '<?php echo $course->getId()?>', date: date},
						type: 'POST',
						success: function(response){
							location.reload();
						}
					});
				}
			});
		});
	</script>
<?php endif; ?>

<h3>Unidades</h3>

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