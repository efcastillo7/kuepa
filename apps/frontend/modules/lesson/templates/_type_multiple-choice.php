<h4 class="head-fieldset"><?php echo $question->getTitle() ?> <br><?php echo $question->getRaw('description') ?></h4>
<fieldset>
  <ul>
    <?php foreach ($question->getAnswers() as $answer): ?>
    <li>
      <input value="<?php echo $answer->getId() ?>" id="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>" class="radio-default" type="radio" name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>]" />
      <label for="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>" name="label-radio" class="radio-label">
        <?php echo $answer->getRaw('title') ?>
      </label>
      <span id="answer_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>"></span>
    </li>
    <?php endforeach ?>
  </ul>
</fieldset>