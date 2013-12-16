<?php use_javascript("/js/libs/message.js") ?>

<?php foreach ($messages as $message): ?>
	<?php echo $message->getContent() ?> <br>
<?php endforeach ?>