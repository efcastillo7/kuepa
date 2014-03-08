<?php $answer_items = $answer->getItems(); ?>

<div class="instructions">
    Escriba el texto debajo, y use corchetes [...] para definir uno o más espacios en blanco
</div>
<div class="row-fluid">
    <div class="span8">
        <div class="span12 text-orange">Texto</div>
        <textarea name="exercise_answer" class="exercise-complete span12"><?php echo $answer->getTitle(); ?></textarea>
    </div>
    <div class="span4 values-container">
        <div class="row-fluid">
            <div class="span9 text-orange">Palabra</div>
            <div class="span3 text-orange">Valor</div>
        </div>
        <?php foreach ($answer_items as $item): ?>
            <div class="row-fluid complete-value">
                <div class="span9 text"><?php echo $item->getTitle(); ?></div>
                <div class="span3 value"><input type="text" name="complete-value-<?php echo $item->getId(); ?>" value="<?php echo $item->getValue(); ?>" class="item_value span12"></div>
                <input type="hidden" class="item_text" name="complete-text-<?php echo $item->getId(); ?>" value="<?php echo $item->getTitle(); ?>">
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="row-fluid complete-value ignore">
    <div class="span9 text"></div>
    <div class="span3 value"><input type="text" class="item_value span12"></div>
    <input type="hidden" class="item_text">
</div>