<h1><?php echo $course->getName() ?></h1>
<div class="row-fluid">
	<div class="span8">
		<h3>Listado de Alumnos</h3>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Legajo</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Primer Acceso</th>
					<th>Último Acceso</th>
					<th>Tiempo total <br>Conectado (minutos)</th>
					<th>Cantidad de Recursos Vistos</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($students as $student): ?>
				<tr>
					<td><?php echo $student->getId() ?></td>
					<td><?php echo $student->getFirstName() ?></td>
					<td><?php echo $student->getLastName() ?></td>
					<td><?php echo $student->getFirstAccess() ?></td>
					<td><?php echo $student->getLastAccess() ?></td>
					<td><?php echo $student->getTotalTime()/60 ?></td>
					<td><?php echo $student->getTotalRecourseViewed() ?></td>
					<td><a href="#" class="btn btn-mini">Ver Más</a></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<div class="span4">
		Gráfico
	</div>
</div>
