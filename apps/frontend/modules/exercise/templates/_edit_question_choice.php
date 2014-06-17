<div class="instructions">
    <button class="add-answer btn btn-success btn-small pull-right">Agregar respuesta</button>
    Seleccione el tipo de pregunta múltiple. Luego, agregue las respuestas posibles para la pregunta. Para marcar la correcta presione sobre la misma.
    <div class="clearfix"></div>
</div>

<div class="answer-container" class="<?php echo $question->getType(); ?>">

    <?php
    foreach ($answers as $answer):
        $title = $answer->getTitle();
        $value = $answer->getValue();
        ?>
        <div class="answer-list <?php if ($answer->getCorrect() == "1") echo "correct"; ?>" data-id="<?php echo $answer->getId(); ?>">
            <button class="btn-gray-light btn-small pull-right remove">
                <i class="icon-trash"></i> Eliminar
            </button>
            <button class="btn-gray-light btn-small pull-right check">
                <i class="icon-check"></i>
            </button>
            <select class="true_false pull-right input-small">
                <option value="true" <?php if($answer->getCorrect() == 1) echo "selected='selected'"; ?>>Verdero
                <option value="false"<?php if($answer->getCorrect() == 0) echo "selected='selected'"; ?>>Falso
            </select>
            <input type="hidden" class="isCorrect pull-right" value="<?php echo $answer->getCorrect(); ?>" name="answer-correct-<?php echo $answer->getId(); ?>">
            <input type="text" name="answer-value-<?php echo $answer->getId(); ?>" class="value pull-right span1" value="<?php echo empty($value) ? "10" : $value; ?>">
            <input type="text" name="answer-text-<?php echo $answer->getId(); ?>" class="title pull-left span8 tinymce" value="<?php echo $title; ?>" placeholder="Ingrese aquí el texto">
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
    <select class="true_false pull-right input-small">
        <option value="true">Verdero
        <option value="false" selected="selected">Falso
    </select>
    <input type="hidden" class="isCorrect pull-right" value="0">
    <input type="text" class="value pull-right span1" value="10">
    <input type="text" class="title pull-left span8" placeholder="Ingrese aquí el texto">
    <div class="clearfix"></div>
</div>