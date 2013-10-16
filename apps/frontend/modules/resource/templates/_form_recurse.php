<form action="<?php echo url_for("resource/createdata?type=$type") ?>" method="POST" id="create-resource-form" enctype='multipart/form-data'>
	<?php echo $form;?>
	<button type="submit" class="btn">Submit</button>
</form>

<script>
    $(document).ready(function() {
        $('.spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});
    });
</script>