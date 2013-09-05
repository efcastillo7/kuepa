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
            success:       function(data, statusText, xhr, $form){
                $("#modal-create-chapter-form-container").html(data.template);
                if(data.status == "success"){
                    location.reload();
                }else{
                    $('#create-chapter-form').ajaxForm(options);
                }
            },
            dataType: 'json'
        };  

        $('#create-chapter-form').ajaxForm(options); 
    });
</script>