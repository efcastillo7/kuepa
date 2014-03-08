<div class="instructions">
    <button class="add-relation-item btn btn-success btn-small pull-right">Agregar relación</button>
    <button class="add-relation-answer btn btn-success btn-small pull-right">Agregar respuesta</button>
    Escriba enunciados y conceptos e indique cuáles se relacionan.
    <div class="clearfix"></div>
</div>
<div class="row-fluid">
    <div class="span7 answers-container">
        <div class="text-orange pull-right">Valor</div>
        <div class="text-orange">Respuestas</div>
        <?php foreach ($answers as $order => $answer): ?>
            <div class="answer-list answer" data-id="<?php echo $answer->getId(); ?>">
                <button class="btn-gray-light btn-small pull-right remove">
                    <i class="icon-trash"></i>
                </button>
                <input type="text" name="relation-answer-value-<?php echo $answer->getId(); ?>" value="<?php echo $answer->getValue(); ?>" class="value pull-right" placeholder="10">
                <div class="pull-left order span1"><?php echo $order + 1; ?></div>
                <input type="text" name="relation-answer-text-<?php echo $answer->getId(); ?>" class="title span8" value="<?php echo $answer->getTitle(); ?>" placeholder="Ingrese aquí la respuesta">
                <div class="clearfix"></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="span5 items-container">
        <div class="text-orange">Relaciones</div>
        <?php foreach ($answers_items as $order => $item): ?>
            <div class="answer-list relation" data-id="<?php echo $item->getId(); ?>">
                <button class="btn-gray-light btn-small pull-right remove">
                    <i class="icon-trash"></i>
                </button>
                <select class="relation pull-right span2" name="relation-item-related-<?php echo $item->getId(); ?>" data-related="<?php echo $item->getExerciseAnswerId(); ?>">
                <?php foreach ($answers as $order => $answer): ?>
                    <option value="<?php echo $answer->getId();?>"<?php if($answer->getId() == $item->getExerciseAnswerId()) echo "selected";?>><?php echo$order+1; ?></option>
                <?php endforeach; ?>
                </select>
                <input type="text" name="relation-item-text-<?php echo $item->getId(); ?>" class="title span8" value="<?php echo $item->getTitle(); ?>" placeholder="Ingrese aquí la relación">
                <div class="clearfix"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="answer-list answer ignore">
    <button class="btn-gray-light btn-small pull-right remove">
        <i class="icon-trash"></i>
    </button>
    <input type="text" class="value pull-right" placeholder="10">
    <div class="pull-left order span1"></div>
    <input type="text" class="title span8" placeholder="Ingrese aquí la respuesta">
    <div class="clearfix"></div>
</div>

<div class="answer-list relation ignore">
    <button class="btn-gray-light btn-small pull-right remove">
        <i class="icon-trash"></i>
    </button>
    <select class="relation pull-right span2"></select>
    <input type="text" class="title span8" placeholder="Ingrese aquí la relación">
    <div class="clearfix"></div>
</div>