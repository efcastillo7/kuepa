<form action="<?php echo url_for("chapter/create") . ($form->isNew() ? "" : "?id=" . $form->getObject()->getId()) ?>" method="POST" id="create-chapter-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>">
    <?php echo $form; ?>
    <button type="submit" class="btn">Submit</button>
</form>

<script type="text/javascript">
    $(document).ready(function() {

        $('#modal-create-chapter-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> .spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});

        tinyMCE.execCommand('mceRemoveEditor', false, 'chapter_description<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>');
        tinyMCE.execCommand('mceAddEditor', false, 'chapter_description<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>');

        $('#modal-create-chapter-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').bind('form-pre-serialize', function(e) {
            tinyMCE.triggerSave();
        });

        //ajax form
        var options = {
            success: function(data, statusText, xhr, $form) {
                $("#modal-create-chapter-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>").html(data.template);
                if (data.status == "success") {
                    location.reload();
                } else {
                    $('#create-chapter-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').ajaxForm(options);

                    tinyMCE.execCommand('mceRemoveEditor', false, 'chapter_description<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>');
                    tinyMCE.execCommand('mceAddEditor', false, 'chapter_description<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>');
                }
            },
            dataType: 'json',
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                // console.log(percentVal);
            },
        };

        $('#create-chapter-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').ajaxForm(options);
    });
</script>