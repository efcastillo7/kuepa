<div class="md-modal" id="modal-create-course-form<?php echo ($form->isNew() ? "" : "-".$form->getObject()->getId()) ?>">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-course-form-container">
                <?php echo include_partial("course/form", array('form' => $form)) ?>
            </div>
            <div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="40">
                <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 40%;"></div>
                <div id="progress">Cargando <span>10%</span></div>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->