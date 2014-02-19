<table>
	<tr>
		<td><b><?php echo $component->getType() ?>:</b> <?php echo $component->getName() ?></td>
	</tr>
	<tr>
		<td>Learning</td>
		<td><b>(Esfuerzo * 0.35  + Eficiencia *(1-0.35) )</b></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $li ?></td>
	</tr>
	<tr>
		<td>Efficiency</td>
		<td><b>(Velocidad*Destreza)<b></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $efi ?></td>
	</tr>
	<tr>
		<td>Effort</td>
		<td><b>Completitud * Persistencia</b></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $efo ?></td>
	</tr>
	<tr>
		<td>Velocity</td>
		<td><b> Duracion Componente = <?php echo $component->getDuration(); ?> /
			Tiempo Invertido = <?php echo LogService::getInstance()->getTotalTime($profile_id, $component); ?><br>

			dist_norm_standard( M_PI / ( 2 * log( Duracion Componente/ Tiempo Invertido ) )
		</b></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $v ?></td>
	</tr>
	<tr>
		<td>Skill</td>
		<td><b>( Promedio de Notas )</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $sk ?></td>
	</tr>
	<tr>
		<td>Completitud: </td>
		<td><b>(# Recursos Vistos/ Recursos Disponibles)</b></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $c ?></td>
	</tr>

	<tr>
		<td>Persistence</td>
		<td><b>( (Recursos Disponibles * Ejercitaciones Aprobadas) / ( Recursos Vistos * Ejercitaciones Disponibles) )</b></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo $p ?></td>
	</tr>

</table>