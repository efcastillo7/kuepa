<form action="<?php echo url_for("chapter/create").($form->isNew()?"":"?id=".$form->getObject()->getId()) ?>" method="POST" class="create-chapter-form">
    <?php echo $form; ?>
    <button type="submit" class="btn">Submit</button>
</form>

<script>
    $(document).ready(function(){
        $('.spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});
        
        $(".addchapter-button").click(function(){
            triggerModalSuccess({id: "modal-create-chapter-form", title: "Crear Unidad", effect: "md-effect-17"});    
        });

        tinyMCE.init({
            selector: "#chapter_description"
        });

        $('#modal-create-chapter-form-container').bind('form-pre-serialize', function(e) {
            tinyMCE.triggerSave(); 
        });

        //ajax form
        var options = {  
            success:       function(data, statusText, xhr, $form){
                $("#modal-create-chapter-form-container").html(data.template);
                if(data.status == "success"){
                    location.reload();
                }else{
                    $('.create-chapter-form').ajaxForm(options);

                    tinyMCE.init({
                        selector: "#chapter_description"
                    });
                }
            },
            dataType: 'json',
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                console.log(percentVal);
            },
        };  

        $('.create-chapter-form').ajaxForm(options); 
    });
</script>