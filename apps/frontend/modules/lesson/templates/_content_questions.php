<?php 
	for ($i=0; $i < $questions->count(); $i++): 
		$sub_questions = $exercise->getQuestionsByLevel($questions[$i]->getId());
		if($sub_questions->count()){
			include_partial("content_estimulo", array('estimulo' => $questions[$i], 'questions' => $sub_questions, 'exercise' => $exercise));
		}else{
	?>
	<div class="question-item">
	  <h4 id="ex-question-<?php echo $i+1?>">
	    <i class="dot8 orange"></i> Pregunta <?php echo $i+1 ?>
	  </h4>
	  <?php include_partial("type_" . $questions[$i]->getType(), array('exercise' => $exercise, 'question' => $questions[$i]))?>
	</div>
	<?php } ?>
<?php endfor ?>