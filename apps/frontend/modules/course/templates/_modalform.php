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
<button type="button" class="btn" id="addcourse">Crear Curso</button>
<script>
    $(document).ready(function(){
        $("#addcourse").click(function(){
            triggerModalSuccess({id: "modal-create-course-form", title: "Crear Curso", effect: "md-effect-17"});    
        });

        //ajax form
        var options = { 
            target:        '#modal-create-course-form-container',   // target element(s) to be updated with server response 
            // beforeSubmit:  showRequest,  // pre-submit callback 
            success:       function(data){
                $('#create-course-form').ajaxForm(options); 
            }  // post-submit callback 
        }; 
     
        // bind form using 'ajaxForm' 
        $('#create-course-form').ajaxForm(options); 
    });
</script>