<table border='1'>
	<tr>
		<th>id</th>
		<td>nombre</td>
		<th>unidad</th>
		<th>descripcion</th>
		<th># palabras</th>
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
			<td><?php echo htmlentities($lesson['nombre']) ?></td>
			<td><?php echo htmlentities($lesson['unidad']) ?></td>
			<td><?php echo htmlentities($lesson['descripcion']) ?></td>
			<td><?php echo $lesson['cantidad_palabras'] ?></td>
		</tr>
		<tr>
			<td colspan="5">Recursos</td>
		</tr>
			<?php foreach ($lesson['recursos'] as $recurso): ?>
				<tr>
					<td>
						Recurso: <br> <?php echo $recurso['id'] ?> <br>
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
					<td><?php echo htmlentities($recurso['nombre']) ?></td>
					<td><?php echo htmlentities($recurso['data']['titulo']) ?></td>
					<td>
						<?php echo $recurso['data']['texto'] ?>
						<?php 
							switch ($recurso['tipo']) {
								case 9:
									# code...
									break;
								case 3:
									echo var_dump($recurso['data']['links']);
									break;
								
								default:
									echo $recurso['data']['url'];
									break;
							}
						?>
					</td>
					<td>
						<?php if($recurso['tipo'] == 9): ?>
							<?php foreach ($recurso['data']['links'] as $link):?>
							<?php 
								$pos = strrpos($link,"/");
								$imgname = str_replace(" ","-", substr($link, $pos+1));
							?>
							<?php echo "$link => $imgname" ?><br>
							<?endforeach;?>
						<?php else: ?>
						
						<?php echo $recurso['data']['links'][0] ?><br>
						<?php endif; ?>

					</td>
				</tr>
			<?php endforeach ?>
		<?php endforeach ?>
		
	<?php endforeach ?>
</table>