<div class="md-modal" id="modal-create-resource-form">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-resource-form-container">
                <?php echo include_partial("resource/form", array('form' => $form)) ?>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->
<script>
    $(document).ready(function() {
        $(".addresource-button").click(function(e) {
            $("#resource_lesson_id").val($(this).attr("lesson"));
            triggerModalSuccess({id: "modal-create-resource-form", title: "Crear Recurso", effect: "md-effect-17"});
        });

        tinyMCE.init({
            selector: "#resource_description,.settinymce"
        });

        $('#modal-create-resource-form-container').bind('form-pre-serialize', function(e) {
            tinyMCE.triggerSave();
        });

        //ajax form
        var options = {
            success: function(data, statusText, xhr, $form) {
                if (data.refresh) {
                    location.reload();
                } else {
                    $("#modal-create-resource-form-container").html(data.template);
                    $('#create-resource-form').ajaxForm(options);

                    tinyMCE.init({
                        selector: "#resource_description,.settinymce"
                    });
                }
            },
            dataType: 'json'
        };

        // bind form using 'ajaxForm' 
        $('#create-resource-form').ajaxForm(options);
    });
</script>