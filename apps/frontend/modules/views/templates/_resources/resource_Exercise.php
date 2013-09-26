<?php $exercise = $resource->getExercise() ?>

<h3><?php echo $exercise->getTitle() ?></h3>
<p><?php echo $exercise->getDescription() ?></p>

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
            var answers = response.data.answers;
            var total_time = new Date().getTime() - init_time;
            total_time = (total_time/60000).toFixed(1);

            for (var key in answers){
            	var objs = $("span#answer_" + exercise.id + "_" + key);
            	for(var i=0;i<answers[key].length;i++){
            		$(objs[i]).html("<img src='/images/icons/" + (answers[key][i].correct ? "ok-icon.jpg" : "error-icon.png") + "'>");
            	}
            }

            var score = (exercise.score.value/exercise.score.total*100).toFixed(2);

            triggerModalExercise({
                id: "modal-exercise", 
                title: "Resultado de su ejercitación", 
                count_questions: exercise.questions.count,
                score: score + " %",
                time: total_time,
                text: "", 
                effect: "md-effect-17"});

            $(".dial").knob({
                'readOnly': true,
                'width': 150,  
            });

            $({value: 0}).animate({value: score}, {
                duration: 1500,
                easing:'swing',
                step: function() 
                {
                    $('.dial').val(Math.ceil(this.value)).trigger('change');
                }
            });
        },
        dataType: 'json'
	};

	$("#exercise_form").ajaxForm(options);
	$('#exercise_form').bind('form-pre-serialize', function(e) {
        tinyMCE.triggerSave();
    });

    $(document).ready(function(){
        
    });


</script>

