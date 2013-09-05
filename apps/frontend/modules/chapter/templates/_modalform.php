<div class="md-modal" id="modal-create-chapter-form">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-chapter-form-container">
            	<?php echo include_partial("chapter/form", array('form' => $form)) ?>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->
<script>
    $(document).ready(function(){
        $(".addchapter-button").click(function(){
            triggerModalSuccess({id: "modal-create-chapter-form", title: "Crear Unidad", effect: "md-effect-17"});    
        });

        //ajax form
        var options = { 
            target:        '#modal-create-chapter-form-container',   // target element(s) to be updated with server response 
            // beforeSubmit:  showRequest,  // pre-submit callback 
            success:       function(data){
                $('#create-chapter-form').ajaxForm(options); 
            }  // post-submit callback 
        }; 
     
        // bind form using 'ajaxForm' 
        $('#create-chapter-form').ajaxForm(options); 
    });
</script>