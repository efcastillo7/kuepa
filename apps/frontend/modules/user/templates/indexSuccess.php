<h1>Datos de usuario</h1>

<form action="<?php echo url_for("user/update") ?>" method="POST" enctype='multipart/form-data'>
    <?php echo $form; ?>
    <button type="submit" class="btn">Guardar</button>
</form>