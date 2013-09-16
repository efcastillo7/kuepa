<form action="<?php echo url_for("course/create").($form->isNew()?"":"?id=".$form->getObject()->getId()) ?>" method="POST" class="create-course-form">
	<?php echo $form;?>
	<button type="submit" class="btn">Submit</button>
</form>

<?php use_javascript("/assets/tinymce/tinymce.min.js") ?>
<?php use_javascript("/assets/tinymce/jquery.tinymce.min.js") ?>
<?php use_javascript("/assets/smartspin/smartspinner.js") ?>
<?php use_stylesheet("/assets/smartspin/smartspinner.css") ?>

<script>
    $(document).ready(function(){
        
        $('.spinner').spinit({min: 1, max: 200, stepInc: 1, pageInc: 20, height: 22, width: 100});
        
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
                    $('.create-course-form').ajaxForm(options);

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

        $('.create-course-form').ajaxForm(options); 
    });
</script>