<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getDescription() ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
  <?php 
  	$input = new sfWidgetFormInput(array(), array('class' => 'input-mini'));
  	//input html
  	$input_txt = $input->render("exercise[" . $exercise->getId() . "][" . $question->getId() . "][]");
  	
  	//replace
  	$value = preg_replace('/\[(.*?)\]/i', $input_txt, $answer->getTitle()); 
  ?>
  <!-- make select -->
  <?php echo $value ?>
<?php endforeach ?>
