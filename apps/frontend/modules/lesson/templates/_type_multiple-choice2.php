<h4 class="head-fieldset"><?php echo $question->getTitle() ?> <br><?php echo $question->getRaw('description') ?></h4>
<fieldset>
  <ul>
    <?php foreach ($question->getAnswers() as $answer): ?>
    <li>
      <input id="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>"  class="checkbox checkbox-default" type="checkbox" name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>][]" value="<?php echo md5($answer->getTitle()) ?>" />
      <label for="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>" class="chk-label checkbox-default">
        <?php echo $answer->getRaw('title') ?>
      </label>
    </li>
    <?php endforeach ?>
  </ul>


  <div class="answer" id="answer_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>">
    <div class="answer-color">
      <div class='answer-ok'><i></i> Correcto</div>
      <div class='answer-error'><i></i> Incorrecto</div>
    </div>
    <div class="answer-show">
      <p class="title6">
        La respuesta correcta es:<br>
        <span class="cyan">B. Opción 2 Hover Item</span>
      </p>
    </div>
    <div class="answer-info">
      <i></i>
      <p class="title6">
        A. Opción 3 Uncheked Item<br>
        <span>
          Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </span>
      </p>
    </div>
  </div>


</fieldset>