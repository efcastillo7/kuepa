<div class="control-group">
    <label class="control-label">Tipo</label>
    <div class="controls">
        <select name="type">
            <option value="multiple-choice" <?php if ($question->getType() == "multiple-choice") echo "selected"; ?>>Opción simple</option>
            <option value="multiple-choice2" <?php if ($question->getType() == "multiple-choice2") echo "selected"; ?>>Opción múltiple</option>
        </select>
    </div>
</div>

<div class="instructions">
    <button class="add-answer btn btn-success btn-small pull-right">Agregar respuesta</button>
    Seleccione el tipo de pregunta múltiple. Luego, agregue las respuestas posibles para la pregunta. Para marcar la correcta presione sobre la misma.
    <div class="clearfix"></div>
</div>

<div class="answer-container">

    <?php
    foreach ($answers as $answer):
        $title = $answer->getTitle();
        $value = $answer->getValue();
    ?>
    <div class="answer-list <?php if($answer->getCorrect() == "1") echo "correct"; ?>" data-id="<?php echo $answer->getId(); ?>">
        <button class="btn-gray-light btn-small pull-right remove">
            <i class="icon-trash"></i> Eliminar
        </button>
        <button class="btn-gray-light btn-small pull-right check">
            <i class="icon-check"></i>
        </button>
        <input type="hidden" class="isCorrect pull-right" value="<?php echo $answer->getCorrect(); ?>" name="answer-correct-<?php echo $answer->getId(); ?>">
        <input type="text" name="answer-value-<?php echo $answer->getId(); ?>" class="value pull-right span1" value="<?php echo empty($value) ? "10" : $value; ?>">
        <input type="text" name="answer-text-<?php echo $answer->getId(); ?>" class="title pull-left span8" value="<?php echo $title; ?>" placeholder="Ingrese aquí el texto">
        <div class="clearfix"></div>
    </div>
    <?php endforeach; ?>

</div>

<div class="answer-list ignore">
    <button class="btn-gray-light btn-small pull-right remove">
        <i class="icon-trash"></i> Eliminar
    </button>
    <button class="btn-gray-light btn-small pull-right check">
        <i class="icon-check"></i>
    </button>
    <input type="hidden" class="isCorrect pull-right" value="0">
    <input type="text" class="value pull-right span1" value="10">
    <input type="text" class="title pull-left span8" placeholder="Ingrese aquí el texto">
    <div class="clearfix"></div>
</div>