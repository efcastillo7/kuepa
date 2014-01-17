<h4 class="head-fieldset"><?php echo $question->getTitle() ?> <br><?php echo $question->getRaw('description') ?></h4>
<fieldset>
  <ul>
    <?php foreach ($question->getAnswers() as $answer): ?>
    <li>
      <input class="checkbox checkbox-default" type="checkbox" name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>][]" value="<?php echo md5($answer->getTitle()) ?>" />
      <label for="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>" class="chk-label checkbox-default">
        <?php echo $answer->getRaw('title') ?>
      </label>
      <span id="answer_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>"></span>
    </li>
    <?php endforeach ?>
  </ul>
</fieldset>