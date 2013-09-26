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

<script>
	var options = {
        success: function(response, statusText, xhr, $form) {
            var exercise = response.data.exercise;
            var answers = response.data.answers;

            for (var key in answers){
            	var objs = $("span#answer_" + exercise.id + "_" + key);
            	for(var i=0;i<answers[key].length;i++){
            		$(objs[i]).html("<img src='/images/icons/" + (answers[key][i].correct ? "ok-icon.jpg" : "error-icon.png") + "'>");
            	}
            }
        },
        dataType: 'json'
	};

	$("#exercise_form").ajaxForm(options);
	$('#exercise_form').bind('form-pre-serialize', function(e) {
        tinyMCE.triggerSave();
    });
</script>