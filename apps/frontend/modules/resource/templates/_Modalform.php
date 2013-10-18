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

        tinymce_values = {
            mode: "none",
            plugins: [
                "advlist autolink lists link image charmap anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste jbimages"
            ],
            relative_urls: false,
            convert_urls: false,
            remove_script_host : false,
            menubar: "edit insert format view table",
            toolbar1: "undo redo | styleselect | bold italic | link image media | code | fullscreen",
            toolbar2: "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            selector: "#resource_description,.settinymce"
        };

        tinyMCE.init(tinymce_values);

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

                    tinyMCE.init(tinymce_values);
                }
            },
            dataType: 'json'
        };

        // bind form using 'ajaxForm' 
        $('#create-resource-form').ajaxForm(options);
    });
</script>