<div class="md-modal" id="modal-create-course-form">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-course-form-container">
                <?php echo include_partial("course/form", array('form' => $form)) ?>
            </div>
            <div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="40">
                <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 40%;"></div>
                <div id="progress">Cargando <span>10%</span></div>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->

<script>
    $(document).ready(function(){
        $(".addcourse-button").click(function(){
            triggerModalSuccess({id: "modal-create-course-form", title: "Crear Curso", effect: "md-effect-17"});    
        });

        tinyMCE.init({
            selector: "#course_description"
        });

        $('#modal-create-course-form-container').bind('form-pre-serialize', function(e) {
            tinyMCE.triggerSave(); 
        });

        //ajax form
        var options = {  
            success: function(data, statusText, xhr, $form){
                $("#modal-create-course-form-container").html(data.template);
                $("#modal-create-course-form #progressbar").hide();
                $("#modal-create-course-form-container").show();

                if(data.status == "success"){
                    location.href = "/course/details/id/" + data.course_id;
                }else{
                    $('#create-course-form').ajaxForm(options);

                    tinyMCE.init({
                        selector: "#course_description"
                    });
                }
            },
            dataType: 'json',
            uploadProgress: function(event, position, total, percentComplete) {
                $("#modal-create-course-form-container").hide();
                var percentVal = percentComplete + '%';
                var obj = $("#modal-create-course-form #progressbar");
                $("#progress span", obj).html(percentVal);
                $(".ui-progressbar-value").width(percentVal);
                obj.show();
            }
        };  

        $('#create-course-form').ajaxForm(options); 
    });
</script>