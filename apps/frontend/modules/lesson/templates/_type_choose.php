<h4 class="head-fieldset"><?php echo $question->getTitle() ?> <br><?php echo $question->getRaw('description') ?></h4>

<fieldset class="lssn-choose">
      <div class="row lssn-refs">
          <div class="col-xs-12 col-md-4">
            <p>Concepto</p>
          </div>
          <div class="col-xs-12 col-md-8">
            <p>Opciones</p>
          </div>
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
          <div class="col-xs-12 col-md-4">
            <p class="title6"><?php echo $answer->getTitle() ?></p>
          </div>
          <div class="col-xs-12 col-md-8">
            <?php 
              $select = new sfWidgetFormChoice(array('choices' => $choices), array('class' => 'form-control lssn-select'));
              echo $select->render("exercise[". $exercise->getId() . "][" . $question->getId() . "][" . $answer->getId() ."]");
             ?>
             <span id='answer_<?php echo $exercise->getId()?>_<?php echo $question->getId()?>'></span>
          </div>
      </div>
      <?php endforeach ?>

      correcto
</fieldset>