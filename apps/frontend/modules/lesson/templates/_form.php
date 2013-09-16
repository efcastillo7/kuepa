<form action="<?php echo url_for("lesson/create").($form->isNew()?"":"?id=".$form->getObject()->getId()) ?>" method="POST" class="create-lesson-form">
    <?php echo $form; ?>
    <button type="submit" class="btn">Submit</button>
</form>

<script>
    $(document).ready(function() {
        $('.spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});
        $(".addlesson-button").click(function(e){
            $("#lesson_chapter_id").val($(this).attr("chapter"));
            triggerModalSuccess({id: "modal-create-lesson-form", title: "Crear Lección", effect: "md-effect-17"});    
        });

        tinyMCE.init({
            selector: "#lesson_description"
        });

        $('#modal-create-lesson-form-container').bind('form-pre-serialize', function(e) {
            tinyMCE.triggerSave(); 
        });

        //ajax form
        var options = {  
            success:       function(data, statusText, xhr, $form){
                $("#modal-create-lesson-form-container").html(data.template);
                if(data.status == "success"){
                    location.reload();
                }else{
                    $('.create-lesson-form').ajaxForm(options);

                    tinyMCE.init({
                        selector: "#lesson_description"
                    });
                }
            },
            dataType: 'json'
        };
     
        // bind form using 'ajaxForm' 
        $('.create-lesson-form').ajaxForm(options); 
    });
</script>