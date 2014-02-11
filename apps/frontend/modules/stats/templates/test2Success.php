<?php  
$chapter = $component->getParents()->getFirst();
$course = $chapter->getParents()->getFirst();

echo 'Curso: '.$course->getName().' --> '; 
echo 'Unidad '.$chapter->getName().' --> '; 
echo '<span class="text-error">Leccion: '.$component->getId().' '.$component->getName().'</span>'; 
?>
<br />
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
		<td><b>( Duracion Componente/ Tiempo Invertido )</b></td>
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
		<td>Persistence</td>
		<td><b>( (Recursos Disponibles * Ejercitaciones Aprobadas) / ( Recursos Vistos * Ejercitaciones Disponibles) )</b></td>
	</tr>
</table>



<table class="table">
	<tr>
		<td colspan="2">Estudiante</td>
		<td>Learning</td>
		<td>Efficiency</td>
		<td>Effort</td>
		<td>Velocity</td>
		<td>Skill</td>
		<td>Completitud</td>
		<td>Persistence</td>
	</tr>

<?php foreach ($stats as $key => $stat) { ?>
	<tr>
		<td><?php echo $stat['profile']->getId() ?></td>
		<td><?php echo $stat['profile']->getFullName() ?></td>
		<td><?php echo $stat['li'] ?></td>
		<td><?php echo $stat['efi'] ?></td>
		<td><?php echo $stat['efo'] ?></td>
		<td><?php echo $stat['v'] ?></td>
		<td><?php echo $stat['sk'] ?></td>
		<td><?php echo $stat['c'] ?></td>
		<td><?php echo $stat['p'] ?></td>
	</tr>
<?php } ?>

</table>


