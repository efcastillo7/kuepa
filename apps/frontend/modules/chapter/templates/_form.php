<form action="<?php echo url_for("chapter/create") ?>" method="POST" id="create-chapter-form">
    <?php echo $form; ?>
    <button type="submit" class="btn">Submit</button>
</form>

<script>
    $(document).ready(function() {
        $('.spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});
    });
</script>