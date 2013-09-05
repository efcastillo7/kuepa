<div class="md-modal" id="modal-create-course-form">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-course-form-container">
            	<?php echo include_partial("course/form", array('form' => $form)) ?>
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

        //ajax form
        var options = {  
            success:       function(data, statusText, xhr, $form){
                $("#modal-create-course-form-container").html(data.template);
                if(data.status == "success"){
                    location.href = "/course/details/id/" + data.course_id;
                }else{
                    $('#create-course-form').ajaxForm(options);
                }
            },
            dataType: 'json'
        };  

        $('#create-course-form').ajaxForm(options); 
    });
</script>