<div class="md-modal" id="modal-create-lesson-form">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-lesson-form-container">
            	<?php echo include_partial("lesson/form", array('form' => $form)) ?>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->
<script>
    $(document).ready(function(){
        $(".addlesson-button").click(function(e){
            $("#lesson_chapter_id").val($(this).attr("chapter"));
            triggerModalSuccess({id: "modal-create-lesson-form", title: "Crear Lección", effect: "md-effect-17"});    
        });

        //ajax form
        var options = { 
            target:        '#modal-create-lesson-form-container',   // target element(s) to be updated with server response 
            // beforeSubmit:  showRequest,  // pre-submit callback 
            success:       function(data){
                $('#create-lesson-form').ajaxForm(options); 
            }  // post-submit callback 
        }; 
     
        // bind form using 'ajaxForm' 
        $('#create-lesson-form').ajaxForm(options); 
    });
</script>