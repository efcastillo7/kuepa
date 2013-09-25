<?php $exercise = $resource->getExercise() ?>

<h3><?php echo $exercise->getTitle() ?></h3>
<p><?php echo $exercise->getDescription() ?></p>


<?php foreach ($exercise->getQuestions() as $question): ?>
  <hr>
  <?php include_partial("views/exercise/type_" . $question->getType(), array('exercise' => $exercise, 'question' => $question))?>
<?php endforeach ?>