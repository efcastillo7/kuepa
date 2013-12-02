<?php foreach ($logs as $log): ?>
<?php include_partial("timeline_point", array('log' => $log)) ?>
<!-- <li class="spacer">
	<div style="height: <?php echo $log->getLapse()?>px;"></div>
</li> -->
<?php endforeach ?>