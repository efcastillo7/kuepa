<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getRaw('description') ?></h5>
</div>
<!-- answ -->
<textarea id="exercise_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>" name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>]" id="" rows="10"></textarea>
<style>
	textarea{ width: 100%;}
</style>
<script>
    tinyMCE.execCommand('mceAddEditor', false, 'exercise_<?php echo $exercise->getId() ?>_<?php echo $question->getId() ?>');
</script>