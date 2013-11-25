<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getRaw('description') ?></h5>
</div>
<!-- answ -->
<?php 
  $choices = array();
  $answers = array();
  foreach ($question->getAnswers() as $answer): ?>
  <?php 
    if($answer->getCorrect() > 0){
      $answers[] = $answer;
    }else{
      $choices[] = $answer->getTitle();
    }
  ?>
<?php endforeach ?>

<?php foreach ($answers as $answer):?>
  <div class="row">
    <div class="span4"><?php echo $answer->getTitle() ?></div>
    <div class="span2">
      <?php 
        $select = new sfWidgetFormChoice(array('choices' => $choices));
        echo $select->render("exercise[". $exercise->getId() . "][" . $question->getId() . "][" . $answer->getId() ."]");
       ?>
       <span id='answer_<?php echo $exercise->getId()?>_<?php echo $question->getId()?>'></span>
    </div>
  </div>

<?php endforeach ?>