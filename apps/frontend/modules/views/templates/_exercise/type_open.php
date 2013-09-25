<div>
    <p><?php echo $question->getTitle() ?></p>
    <h5><?php echo $question->getDescription() ?></h5>
</div>
<!-- answ -->
<textarea name="exercise[<?php echo $exercise->getId() ?>][<?php echo $question->getId() ?>]" id="" rows="10"></textarea>
<style>
	textarea{ width: 100%;}
</style>