<?php $exercise = $resource->getExercise() ?>

<h3><?php echo $exercise->getTitle() ?></h3>
<p><?php echo $exercise->getRaw('description') ?></p>

<form action="<?php echo url_for("exercise/validate") ?>" method="post" id="exercise_form">
<?php foreach ($exercise->getQuestions() as $question): ?>
  <hr>
  <?php include_partial("views/exercise/type_" . $question->getType(), array('exercise' => $exercise, 'question' => $question))?>
<?php endforeach ?>
<input type="hidden" name="exercise_id" value="<?php echo $exercise->getId() ?>">
<input type="submit" value="Validar">
</form>

<!-- Modals -->
<?php include_partial("views/modals/exercise") ?>

<script>
    var init_time = new Date().getTime();;
	var options = {
        success: function(response, statusText, xhr, $form) {
            var exercise = response.data.exercise;
            var answers = response.data.questions;
            var total_time = new Date().getTime() - init_time;
            total_time = (total_time/60000).toFixed(1);

            for (var key in answers){
            	var objs = $("span#answer_" + exercise.id + "_" + key);
            	for(var i=0;i<answers[key]['answers'].length;i++){
            		$(objs[i]).html("<img src='/images/icons/" + (answers[key]['answers'][i].correct ? "ok-icon.jpg" : "error-icon.png") + "'>");
            	}
            }

            var score = (exercise.score.value/exercise.score.total*100).toFixed(2);

            aaa(response.data);

            //add dependencies if score
            if(score < 70){
                var ans = confirm('desea agregar dependencias?');
                if(ans){
                    classie.addClass( document.getElementById( 'cbp-spmenu-s2' ), 'cbp-spmenu-open' );
                    lpService.addDependencies({
                        course_id: course_id, lesson_id: lesson_id, chapter_id: chapter_id,
                        onSuccess: function(item){
                            addItemsToPath(item);
                        },
                        onError: function(data){
                            alert('Ya tiene esa lección');
                        }
                    });
                }
            }
        },
        dataType: 'json'
	};

	$("#exercise_form").ajaxForm(options);
	$('#exercise_form').bind('form-pre-serialize', function(e) {
        tinyMCE.triggerSave();
    });

    function aaa(data){
        var el = $("#modal-exercise-fail");

        $('.md-close',el).click(function(e){
            e.stopPropagation();
            $(el).removeClass('md-show');
        });

        console.log(data);

        if(data.dependencies.length > 0){
            $(".lessons", el).show();
            var obj = $(".lessons .lesson", el);
            var parent = obj.parent();
            for(var i=0; i< data.dependencies.length; i++){
                var clone = obj.clone();
                $("h5",clone).html(data.dependencies[i].lesson.name);

                parent.append(clone);
            }
        }
        
        el.show();
        el.addClass("md-show");
    }

    $(document).ready(function(){
        
    });


</script>

