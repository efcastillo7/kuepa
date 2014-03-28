<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<h2><?php echo $course->getName() ?></h2>

<style>
	table{table-layout: fixed;}
	table td{overflow: hidden;}
	.unit {background-color: gainsboro;}
	.bar { text-align: center}
	.progress { margin-bottom: 0px; }
</style>




<!-- DASHBOARD AEROLAB -->


<div class="container clearpadding">
    <div class="dashboard-left">
        <nav class="nav-dashboard">
          <ul>
            <li><a class="first" href="dashboard-a.php">Lista</a></li>
            <li><a href="dashboard-b.php">Fichas</a></li>
            <li><a class="last" href="dashboard-c.php">Comparativa</a></li>
          </ul>
        </nav>

        <div class="order">
          <select class="selectpicker" id="materia">
            <option>Ordenar por</option>
            <option>Opción 1</option>
            <option>Opción 2</option>
          </select>
        </div>

      </div><!-- /dashboard-left -->
  </div> <!-- /container -->
<div class="clear"></div>

<div class="container-fluid">
	<div >
	    <div class="comparative-table general-data">
	        <ul>
	          <li class="title-level-3">
	            <span class="name"></span>
	            <span>Tiempo dedicado</span>
	            <span>Índice de aprendizaje</span>
	            <span>Última conexión</span>
	            <span>Lecciones completadas</span>
	            <span>Nota promedio</span>
	          </li>
	          <!-- RENGLONES DE ALUMNOS -->
	          <li class="renglon" rel="tooltip" data-placement="top" title="40% completado">
	            <span class="name">
	              <div class="indicator" style="width: 100%;"></div>
	              <span class="triangle red"></span>
	              Nombre bastante largo de este alumno
	            </span>
	            <span>30hs</span>
	            <span>70%</span>
	            <span>10 <small>Días</small></span>
	            <span>15/47</span>
	            <span>3.1</span>
	          </li>
	          <li class="renglon darker" rel="tooltip" data-placement="top" title="40% completado">
	            <span class="name">
	              <div class="indicator" style="width: 10%;"></div>
	              <span class="triangle orange"></span>
	              Nombre del alumno
	            </span>
	            <span>30hs</span>
	            <span>70%</span>
	            <span>10 <small>Días</small></span>
	            <span>15/47</span>
	            <span>3.1</span>
	          </li>
	          <li class="renglon" rel="tooltip" data-placement="top" title="40% completado">
	            <span class="name">
	              <div class="indicator" style="width: 50%;"></div>
	              <span class="triangle green"></span>
	              Nombre del alumno
	            </span>
	            <span>30hs</span>
	            <span>70%</span>
	            <span>10 <small>Días</small></span>
	            <span>15/47</span>
	            <span>3.1</span>
	          </li>
	          <!-- /RENGLONES DE ALUMNOS -->
	        </ul>
	    </div>
	    <div class="comparative-table specific-data">
	        <ul>
	          <!-- TITULO NIVEL 1 -->
	          <li class="title-level-1">
	              Unidad uno
	              <span class="btn-lessons" data-target=".lecciones">
	                <i class="spr ico-arrow-table blank"></i>
	              </span>
	          </li>
	          <!-- /TITULO NIVEL 1 -->

	          <!-- TITULOS NIVEL 2 -->
	          <li class="title-level-2">
	            <!-- TITULO NIVEL 2 se muestra por default -->
	            <span class="displayed">Resumen</span>
	            <!-- /TITULO NIVEL 2 se muestra por default -->

	            <!-- COLUMNAS OCULTAS POR DEFAULT -->
	            <span class="none lecciones column">Los diferentes actores publicos y privados, individuales y colectivos, locales y extralocales en las problematicas ambientales
	              <span class="button" data-target=".l1">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>

	            <span class="none lecciones column">Lección dos
	              <span class="button" data-target=".l2">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT -->
	          </li>
	          <!-- /TITULOS NIVEL 2 -->

	          <!-- TITULOS NIVEL 3 -->
	          <li class="title-level-3">
	            <span>Tiempo dedicado</span>
	            <span>Índice de aprendizaje</span>
	            <span>Nota</span>
	            <span>Progreso</span>

	            <!-- COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->
	            <span class="none l1 collapsable first">Tiempo dedicado</span>
	            <span class="none l1 collapsable">Índice de aprendizaje</span>
	            <span class="none l1 collapsable">Nota</span>
	            <span class="none l1 progreso collapsable column">Progreso</span>

	            <span class="none l2 collapsable first">Tiempo dedicado</span>
	            <span class="none l2 collapsable">Índice de aprendizaje</span>
	            <span class="none l2 collapsable">Nota</span>
	            <span class="none l2 progreso collapsable column">Progreso</span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->

	          </li>
	          <!-- /TITULOS NIVEL 3 -->

	          <!-- RENGLONES -->
	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon darker">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span class="border-right">70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>
	          <!-- /RENGLONES -->

	        </ul>
	    </div>

	    <div class="comparative-table specific-data">
	        <ul>
	          <!-- TITULO NIVEL 1 -->
	          <li class="title-level-1">
	              Unidad uno
	              <span class="btn-lessons" data-target=".lecciones">
	                <i class="spr ico-arrow-table blank"></i>
	              </span>
	          </li>
	          <!-- /TITULO NIVEL 1 -->

	          <!-- TITULOS NIVEL 2 -->
	          <li class="title-level-2">
	            <!-- TITULO NIVEL 2 se muestra por default -->
	            <span class="displayed">Resumen</span>
	            <!-- /TITULO NIVEL 2 se muestra por default -->

	            <!-- COLUMNAS OCULTAS POR DEFAULT -->
	            <span class="none lecciones column">Los diferentes actores publicos y privados, individuales y colectivos, locales y extralocales en las problematicas ambientales
	              <span class="button" data-target=".l1">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>

	            <span class="none lecciones column">Lección dos
	              <span class="button" data-target=".l2">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT -->
	          </li>
	          <!-- /TITULOS NIVEL 2 -->

	          <!-- TITULOS NIVEL 3 -->
	          <li class="title-level-3">
	            <span>Tiempo dedicado</span>
	            <span>Índice de aprendizaje</span>
	            <span>Nota</span>
	            <span>Progreso</span>

	            <!-- COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->
	            <span class="none l1 collapsable first">Tiempo dedicado</span>
	            <span class="none l1 collapsable">Índice de aprendizaje</span>
	            <span class="none l1 collapsable">Nota</span>
	            <span class="none l1 progreso collapsable column">Progreso</span>

	            <span class="none l2 collapsable first">Tiempo dedicado</span>
	            <span class="none l2 collapsable">Índice de aprendizaje</span>
	            <span class="none l2 collapsable">Nota</span>
	            <span class="none l2 progreso collapsable column">Progreso</span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->

	          </li>
	          <!-- /TITULOS NIVEL 3 -->

	          <!-- RENGLONES -->
	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon darker">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span class="border-right">70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>
	          <!-- /RENGLONES -->

	        </ul>
	    </div>
	</div>
</div>

<script src="js/dashboard.js"></script>



<!-- /DASHBOARD AEROLAB -->




<table class="table table-hover">
	<thead>
		<tr>
			<td colspan="2"></td>
			<?php foreach ($students as $student): ?>
			<th><?php echo $student->getFullName() ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Fecha de Primera Conexión</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo utcToLocalDate($student->getFirstAccess(), "dd/M/yyyy H:mm") ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Fecha de Última Conexión</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Tiempo Total Dedicado</td>
			<?php foreach ($students as $student): ?>
			<th>
				<?php if ($student->getTotalTime($sf_data->getRaw('course')) > 0): ?>
					<?php echo gmdate("H:i:s",$student->getTotalTime($sf_data->getRaw('course'))) ?>
				<?php else: ?>
					-
				<?php endif ?>
			</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Promedio de Horas por Semana</td>
			<?php foreach ($students as $student): ?>
			<th> 
				<?php echo gmdate("H:i", $student->getWeekTime($sf_data->getRaw('course'))) ?> hs 
			</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Nota Promedio</td>
			<?php foreach ($students as $student): ?>
			<th>-</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Avance General</td>
			<?php foreach ($students as $student): ?>
			<td>
				<div class="progress">
					<?php if ($student->getComponentStatus($course->getId()) < 35): ?>
					<div class="bar bar-danger" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>	
					<?php elseif ($student->getComponentStatus($course->getId()) < 70): ?>
					<div class="bar bar-warning" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
					<?php else: ?>
					<div class="bar bar-success" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
					<?php endif ?>
				</div>
			</td>
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th colspan="<?php echo 2+$students->count() ?>"><br> Detalle por Unidad</th>
		</tr>
		<?php foreach ($course->getChapters() as $chapter): ?>
			<tr class="unit">
				<td colspan="2"><b><?php echo $chapter->getName() ?></b></td>
				<?php foreach ($students as $student): ?>
				<td>
					<?php if ($student->getComponentStatus($chapter->getId()) == 100): ?>
						<span class="label label-success"><i class='icon-ok'></i></span>
					<?php endif; ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php foreach ($chapter->getLessons() as $lesson): ?>
			<tr>
				<td></td><td><?php echo $lesson->getName() ?></td>	
				<?php foreach ($students as $student): ?>
				<td>
					<?php if ($student->getComponentStatus($lesson->getId()) == 100): ?>
						<i class='icon-ok'></i>
					<?php elseif($student->getComponentStatus($lesson->getId()) > 0): ?>
						<?php echo $student->getComponentStatus($lesson->getId()) ?> %
					<?php else: ?>
						-
					<?php endif ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php endforeach ?>

		<?php endforeach ?>
	</tbody>
	
</table>
				