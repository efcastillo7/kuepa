<form action="<?php echo url_for("resource/createdata?type=$type") ?>" method="POST" id="create-resource-form">
	<?php echo $form;?>
	<button type="submit" class="btn">Submit</button>
</form>