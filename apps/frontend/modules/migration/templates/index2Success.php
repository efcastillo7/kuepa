<table border='1'>
	<tr>
		<th>id</th>
		<td>nombre</td>
		<th>unidad</th>
		<th>descripcion</th>
		<th>Links</th>
	</tr>
	<?php foreach ($unidades as $id => $unidad): ?>
	<tr>
		<td colspan='5'>UNIDAD: <?php echo $unidad['nombre'] ?></td>
	</tr>
		<?php foreach ($unidad['lessons'] as $lesson): ?>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>Leccion: <br> <?php echo $lesson['id'] ?></td>
			<td><?php echo $lesson['nombre'] ?></td>
			<td><?php echo $lesson['unidad'] ?></td>
			<td><?php echo ($lesson['descripcion']) ?></td>
			<td><?php echo $lesson['cantidad_palabras'] ?></td>
		</tr>
		<tr>
			<td colspan="5">Recursos</td>
		</tr>
			<?php foreach ($lesson['recursos'] as $recurso): ?>
				<tr>
					<td>
						Tipo: <?php 
							switch ($recurso['tipo']) {
								case 9:
									echo "texto";
									break;
								case 3:
									echo "video interno";
									break;
								
								default:
									echo "video";
									break;
							}
						?>
					</td>
					<td><?php echo $recurso['nombre'] ?></td>
					<td><?php echo $recurso['data']['titulo'] ?></td>
					<td>
						<?php 
							switch ($recurso['tipo']) {
								case 9:
									# code...
									break;
								case 3:
									// echo var_dump($recurso['data']['links']);
									break;
								
								default:
									echo $recurso['data']['url'];
									break;
							}
						?>
					</td>
					<td>
						<?php if($recurso['tipo'] == 9): ?>
							
						<?php else: ?>
						
						<?php if (isset($recurso['data']['links'][0])){
							if(strpos($recurso['data']['links'][0],"rec") === false){
								echo $recurso['data']['links'][0];
							}else{
								echo "http://www.kuepa.com/escuela/video/" . $recurso['data']['links'][0];
							}
						} ?><br>
						<?php endif; ?>

					</td>
				</tr>
			<?php endforeach ?>
		<?php endforeach ?>
		
	<?php endforeach ?>
</table>