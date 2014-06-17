<!--No se encontró aún la forma de crear polígonos dinámicamente en KineticJS -->

<div class="instructions">
    <div class="btn-group pull-right">
        <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">
            <i class="icon-plus-sign"></i> Agregar Zona
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu addZone">
            <li data-type="circle">
                <a href="#" class="zone-circle"><i class="icon-pencil"></i> Círculo</a>
            </li>
            <li data-type="rectangle">
                <a href="#" class="zone-rectangle"><i class="icon-pencil"></i> Rectangulo</a>
            </li>
            <!--li data-type="polygon">
                <a href="#" class="zone-polygon"><i class="icon-pencil"></i> Polígono</a>
            </li-->
        </ul>
    </div>
    Agregue las figuras que correspondan con las zonas interactivas de la imagen.
    <div class="clearfix"></div>
</div>
<div id="image-edition" class="row-fluid">
    <div class="span5">
        <div class="tool-header">Zonas</div>
        <div class="zones-container">
            <?php
            foreach ($answers as $i => $answer):
                $shapeData = json_decode($answer->getComment());
                ?>
                <div class="tool-item row-fluid" data-id="<?php echo $answer->getId(); ?>">
                    <button class="btn-gray-light btn-small pull-right remove">
                        <i class="icon-trash"></i>
                    </button>
                    <div class="color zone-color-<?php echo $i + 1; ?> span1">&nbsp;</div>
                    <input type="text" placeholder="Título" class="span5 title" name="zone-text-<?php echo $answer->getId(); ?>" value="<?php echo $answer->getTitle(); ?>">
                    <select class="span3 type">
                        <option value="circle" <?php if ($shapeData["shape"] == "circle") echo "selected"; ?>>Círculo</option>
                        <option value="rectangle" <?php if ($shapeData["shape"] == "rectangle") echo "selected"; ?>>Rectángulo</option>
                        <!--option value="polygon" <?php if ($shapeData["shape"] == "polygon") echo "selected"; ?>>Polígono</option-->
                    </select>
                    <input type="text" placeholder="10" class="value" value="<?php echo $answer->getValue(); ?>" name="zone-value-<?php echo $answer->getId(); ?>">
                    <input type="hidden" class="shape-data" name="zone-type-<?php echo $answer->getId(); ?>" value='<?php echo $answer->getComment(); ?>'>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="span7">
        <div id="stage"></div>
    </div>
</div>

<div class="tool-item row-fluid ignore">
    <button class="btn-gray-light btn-small pull-right remove">
        <i class="icon-trash"></i>
    </button>
    <div class="color zone-color-1 span1">&nbsp;</div>
    <input type="text" placeholder="Título" class="span5 title">
    <select class="span3 type">
        <option value="circle">Círculo</option>
        <option value="rectangle">Rectángulo</option>
        <!--option value="polygon">Polígono</option-->
    </select>
    <input type="text" placeholder="10" class="value">
    <input type="hidden" class="shape-data" value='{"radius":10,"stroke":"lightgray","strokeWidth":1}'>
</div>
