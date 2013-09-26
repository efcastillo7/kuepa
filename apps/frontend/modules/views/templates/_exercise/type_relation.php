<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getRaw('description') ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
  <?php 
  	//get options
  	preg_match_all("/\[(.*?)\]/",$answer->getTitle(),$m);
    $values = $m[1];
    //shuffle
    shuffle($values);
  	$options = array_unique(array_merge(array('' => ''), $values));

  	$select = new sfWidgetFormChoice(array('choices' => array_combine($options,$options)));
  	//html
  	$select_txt = $select->render("exercise[". $exercise->getId() . "][" . $question->getId() . "][]");
    $select_txt .= "<span id='answer_" . $exercise->getId() . "_" . $question->getId() . "'></span>";
  	
  	$value = preg_replace('/\[(.*?)\]/i', $select_txt, $answer->getTitle()); 

  ?>
  <!-- make select -->
  <?php echo $value ?>
<?php endforeach ?>
