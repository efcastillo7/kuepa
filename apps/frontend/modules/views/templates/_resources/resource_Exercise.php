<?php $exercise = $resource->getExercise() ?>

<h3><?php echo $exercise->getTitle() ?></h3>
<p><?php echo $exercise->getDescription() ?></p>


<?php foreach ($exercise->getQuestions() as $question): ?>
  <hr>
  <?php include_partial("views/exercise/type_" . $question->getType(), array('exercise' => $exercise, 'question' => $question))?>
<?php endforeach ?>


<!-- 4 -->
<hr>
<div>
    <p>Pregunta 4 : Punto 4</p>
    <h5>Relacione Conceptos</h5>
</div>
<!-- answ -->
<div class="row">
    <div class="span4">Tu padre es</div>
    <div class="span3">
        <select>
          <option value=""></option>
          <option value="Argetina">Argentina</option>
          <option value="Chubut">Chubut</option>
          <option value="Tierra del Fuego">Tierra del Fuego</option>
        </select>
    </div>
</div>