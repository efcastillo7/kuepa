<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getDescription() ?></h5>
</div>
<!-- answ -->
<?php foreach ($question->getAnswers() as $answer): ?>
<label class="checkbox">
  <input type="checkbox" name="option" id="opti" value="<?php echo $answer->getTitle() ?>">
  <?php echo $answer->getTitle() ?>
</label>	
<?php endforeach ?>
