<h4 class="head-fieldset">
  <?php echo $question->getTitle() ?> <br>
  <?php echo $question->getRaw('description') ?>
</h4>
<fieldset>
  <?php foreach ($question->getAnswers() as $answer): ?>
  <?php 
    $input = new sfWidgetFormInput(array(), array('class' => 'input-small orange'));
    //input html
    $input_txt = $input->render("exercise[" . $exercise->getId() . "][" . $question->getId() . "][]");
    $input_txt .= "<span id='answer_" . $exercise->getId() . "_" . $question->getId() . "'></span>";
    
    //replace
    $value = preg_replace('/\[(.*?)\]/i', $input_txt, $answer->getTitle()); 
  ?>
  <!-- make select -->
  <?php echo $value ?>
<?php endforeach ?>
</fieldset>