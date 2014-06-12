<div class="question-item">
  <h4 id="ex-estimulo-<?php echo $numero+1?>">
    Estimulo: <?php echo $estimulo->getTitle() ?> <br>
  	<?php echo $estimulo->getRaw('description') ?>
  </h4>
</div>
<?php include_partial("content_questions", array('questions' => $questions, 'exercise' => $exercise, 'numero' => $numero, 'type' => "estimulo")) ?>
