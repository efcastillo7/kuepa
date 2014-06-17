<?php foreach ($messages as $message):?>
	<?php include_partial($message->getName(), array('profile' => $profile, 'message' => $message)) ?>
<?php endforeach; ?>