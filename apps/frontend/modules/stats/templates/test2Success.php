<?php  
//$chapter = $component->getParents()->getFirst();
//$chapter = $component;
//$course = $chapter->getParents()->getFirst();
$course =  $component;

echo 'Curso: '.$course->getId().' '.$course->getName().' '; 
//echo 'Unidad '.$chapter->getId().' '.$chapter->getName().' --> '; 
//echo '<span class="text-error">Leccion: '.$component->getId().' '.$component->getName().'</span>'; 
?>
<div class="container">
	<div class="row">
	  <div class="span8 offset4">
			<form action="" method="get" class="form"> 
		 			<label>Course</label>
					<select name="course_id" id="course_id">
					  <?php foreach ($courses as $key => $c) { ?>
					  	<?php $selected = ( $course->getId() == $c->getId() ) ? 'selected="selected"': '' ; ?>
					    <option <?php echo $selected ?> value="<?php echo $c->getId(); ?>"><?php echo $c->getName(); ?></option>
					  <?php } ?>
					</select> 
					<label>Registros x Pagina</label>
					<select name="limit" id="limit">
						<?php for($i=5;$i<=150;$i+=5){ ?>
					  	<?php $selected = ( $limit == $i ) ? 'selected="selected"': '' ; ?>
							<option <?php echo $selected ?> value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
					</select>
		 
					<label>Page</label>
					<select name="offset" id="offset">
						<?php for($i=0;$i<=150;$i+=$limit){ ?>
					  	<?php $selected = ( $offset == $i ) ? 'selected="selected"': '' ; ?>
							<option <?php echo $selected ?> value="<?php echo $i ?>"><?php echo $i/$limit ?></option>
						<?php } ?>
					</select>

					<button type="submit" class="btn btn-mini btn-success">Filter</button>
		 	</form>
		</div>
	</div>
</div>
Indices:
<table>
	<tr>
		<td>Learning</td>
		<td><b>(Esfuerzo * 0.35  + Eficiencia *(1-0.35) )</b></td>
	</tr>
	<tr>
		<td>Efficiency</td>
		<td><b>(Velocidad*Destreza)<b></td>
	</tr>
	<tr>
		<td>Effort</td>
		<td><b>Completitud * Persistencia</b></td>
	</tr>
	<tr>
		<td>Velocity</td>
		<td><b>dist_norm_standard( M_PI / ( 2 * log( Duracion Componente/ Tiempo Invertido ) )</b></td>
	</tr>
	<tr>
		<td>Skill</td>
		<td><b>( Promedio de Notas )</b></td>
	</tr>
	<tr>
		<td>Completitud: </td>
		<td><b>(# Recursos Vistos/ Recursos Disponibles)</b></td>
	</tr>

	<tr>
		<td>Persistence(This week)</td>
		<td><b>dist_norm_standard( M_PI / ( 2 * log( Tiempo Invertido semana /Tiempo Sugerido Semana ) )</b></td>
	</tr>
</table>


<table class="table">
	<tr>
		<td colspan="2">Estudiante</td>
		<th>Learning</th>
		<th>Efficiency</th>
		<th>Effort</th>
		<td>Duration(seg)</td>
		<td>Invest Time</td>
		<th>Velocity</th>
		<th>Skill</th>
		<td>Available Resources</td>
		<td>Viewed Resources</td>
		<th>Completitud</th>
		<th>Invest Time</th>
		<th>needed Time</th>
		<th>Persistence</th>
	</tr>

<?php foreach ($stats as $key => $stat) { ?>
	<tr>
		<td><?php echo $stat['profile']->getId() ?></td>
		<td><?php echo $stat['profile']->getFullName() ?></td>
		<td><?php echo $stat['li'] ?></td>
		<td><?php echo $stat['efi'] ?></td>
		<td><?php echo $stat['efo'] ?></td>
		<td><?php echo $stat['dc'] ?></td>
		<td><?php echo $stat['ti'] ?></td>
		<td><?php echo $stat['v'] ?></td>
		<td><?php echo $stat['sk'] ?></td>
		<td><?php echo $stat['available_resources'] ?></td>
		<td><?php echo $stat['viewed_resources'] ?></td>
		<td><?php echo $stat['c'] ?></td>
		<td><?php echo $stat['invest_time'] ?></td>
		<td><?php echo $stat['needed_time'] ?></td>
		<td><?php echo $stat['p'] ?></td>
	</tr>
<?php } ?>

</table>


