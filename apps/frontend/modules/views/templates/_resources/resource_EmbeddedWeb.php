<iframe src="<?php echo $resource->getContent() ?>" frameborder="0"></iframe>
<p>Fuente: <?php echo $resource->getContent() ?></p>
<p>Creado el: <?php echo $resource->getCreatedAt() ?></p>
<?php if ($resource->getCreatedAt() != $resource->getUpdatedAt()): ?>
	<p>Última Modificación: <?php echo $resource->getUpdatedAt() ?></p>	
<?php endif ?>
