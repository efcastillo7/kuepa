<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getDescription() ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
  <?php 
  	$value = preg_replace('/\[(.*?)\]/i', "<input type='text' name='question[" . $question->getId() . "][]' class='input-mini'>", $answer->getTitle()); 
  // $value = preg_replace('/\[(.*?)\]/i', "__input__", $answer->getTitle()); 
  ?>
  <!-- make select -->
  <?php echo $value ?>
<?php endforeach ?>
