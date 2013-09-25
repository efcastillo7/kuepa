<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getDescription() ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
  <?php 
  	//get options
  	preg_match_all("/\[(.*?)\]/",$answer->getTitle(),$m);
  	$options = array_unique(array_merge(array('' => ''),$m[1]));

  	$select = new sfWidgetFormChoice(array('choices' => array_combine($options,$options)));
  	//html
  	$select_txt = $select->render("question[". $exercise->getId() . "][" . $question->getId() . "][]");
  	
  	$value = preg_replace('/\[(.*?)\]/i', $select_txt, $answer->getTitle()); 

  ?>
  <!-- make select -->
  <?php echo $value ?>
<?php endforeach ?>
