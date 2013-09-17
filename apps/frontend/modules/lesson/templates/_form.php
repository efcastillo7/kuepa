<form action="<?php echo url_for("lesson/create") . ($form->isNew() ? "" : "?id=" . $form->getObject()->getId()) ?>" method="POST" id="create-lesson-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>">
    <?php echo $form; ?>
    <button type="submit" class="btn">Submit</button>
</form>

<script>
    $(document).ready(function() {

        $('#modal-create-lesson-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> .spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});

        //ajax form
        var options = {
            success: function(data, statusText, xhr, $form) {
                $("#modal-create-lesson-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>").html(data.template);
                if (data.status == "success") {
                    location.reload();
                } else {
                    $('#create-lesson-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').ajaxForm(options);
                }
            },
            dataType: 'json'
        };

        // bind form using 'ajaxForm' 
        $('#create-lesson-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').ajaxForm(options);
    });
</script>