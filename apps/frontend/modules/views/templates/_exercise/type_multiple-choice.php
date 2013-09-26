<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getDescription() ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
<label class="radio">
  <input type="radio" name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>]" id="exercise_<?php echo $question->getId() ?>_<?php echo $answer->getId() ?>" value="<?php echo $answer->getTitle() ?>">
  <?php echo $answer->getTitle() ?> <span id="answer_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>"></span>
</label>
<?php endforeach ?>