<div class="md-modal" id="modal-create-lesson-form<?php echo ($form->isNew() ? "" : "-".$form->getObject()->getId()) ?>">
    <div class="md-content">
        <h3 id="title"></h3>
        <div>
            <div id="modal-create-lesson-form-container">
            	<?php echo include_partial("lesson/form", array('form' => $form)) ?>
            </div>
            <button class="md-close">Cerrar</button>
        </div>
    </div>
</div>
<div class="md-overlay"></div><!-- the overlay element -->