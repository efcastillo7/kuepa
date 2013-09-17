<form action="<?php echo url_for("course/create") . ($form->isNew() ? "" : "?id=" . $form->getObject()->getId()) ?>" method="POST" id="create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>">
    <?php echo $form; ?>
    <button type="submit" class="btn">Submit</button>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        
        $('#modal-create-course-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> .spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});

        //ajax form
        var options = {
            success: function(data, statusText, xhr, $form) {
                $("#modal-create-course-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>").html(data.template);
                $("#modal-create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> #progressbar").hide();
                $("#modal-create-course-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>").show();

                if (data.status == "success") {
                    location.href = "/course/details/id/" + data.course_id;
                } else {
                    $('#create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').ajaxForm(options);

                    //tinyMCE.init({
                    //    selector: "#modal-create-course-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> #course_description"
                    //});
                }
            },
            dataType: 'json',
            uploadProgress: function(event, position, total, percentComplete) {
                $("#modal-create-course-form-container<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>").hide();
                var percentVal = percentComplete + '%';
                var obj = $("#modal-create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> #progressbar");
                $("#modal-create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> #progress span", obj).html(percentVal);
                $("#modal-create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?> .ui-progressbar-value").width(percentVal);
                obj.show();
            }
        };

        $('#create-course-form<?php echo ($form->isNew() ? "" : "-" . $form->getObject()->getId()) ?>').ajaxForm(options);
    });
</script>