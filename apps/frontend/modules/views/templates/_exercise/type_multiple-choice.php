<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getRaw('description') ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
<label class="radio">
  <span id="answer_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>"></span> <input type="radio" name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>]" id="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>" value="<?php echo $answer->getId() ?>">
  <?php echo $answer->getRaw('title') ?>
</label>
<?php endforeach ?>