<?php use_javascript("/assets/khan/khan-exercise.js") ?>
<h4><?php echo $resource->getType() ?></h4>
<div class="exercise">
  <div class="vars">
    <var id="ANSWER">Pesa lo mismo</var>
  </div>

  <div class="problems">
    <div>
      <div class="question">
        <div>Qué es más pesado: un kilo de plumas o un kilo de oro?</div>
      </div>
      <p class="solution">Ninguna de las anteriores</p>
      <ul class="choices">
        <li>Plumas</li>
        <li>Oro</li>
      </ul>
    </div>
  </div>

  <div class="hints">
    <p>Ambos dos tiene el mismo peso ya que ambos tienen un <b>kilo</b></p>
  </div>
</div>
<p>
    <?php echo $resource->getContent() ?>
</p>