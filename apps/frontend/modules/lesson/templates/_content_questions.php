<?php 

	for ($i = 0; $i < $questions->count(); $i++): 
		$sub_questions = $exercise->getQuestionsByLevel($questions[$i]->getId());
		if($sub_questions->count()){
			include_partial("content_estimulo", array('estimulo' => $questions[$i], 'questions' => $sub_questions, 'exercise' => $exercise, 'numero' => $numero));
			$numero+=$sub_questions->count();
		}
		else{
			?>
			<div class="question-item">
			  <h4 id="ex-question-<?php echo $numero+1; ?>">
			    <i class="dot8 orange"></i> Pregunta <? echo ($numero)+1;?>
			  </h4>
			  <?php include_partial("type_" . $questions[$i]->getType(), array('exercise' => $exercise, 'question' => $questions[$i]))?>
			</div>
	<?php $numero++;}?>
<?php endfor ?>