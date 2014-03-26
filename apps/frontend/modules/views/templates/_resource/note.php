<?php use_helper('Date') ?>
<?php use_helper('LocalDate') ?>

<div class="box-annotations" id="note-<?php echo $note->getId() ?>">
    <div class="wrap wrap-arrow-gray">
      <i class="spr ico-annotations"></i>
    </div>
    <div class="data">
      <input id="edit-note-input-<?php echo $note->getId() ?>" class="input_add_note span8 hide" type="text" value="<?php echo $note->getContent() ?>" edit-note-id="<?php echo $note->getId() ?>">
      <p class="annotation">
        <?php echo $note->getContent() ?>
      </p>
      <p class="date">
        El <?php echo utcToLocalDate($note->getUpdatedAt(), 'dd/MM/yyyy') ?> a las <?php echo utcToLocalDate($note->getUpdatedAt(), 'HH:mm') ?>hs
      </p>
      <!-- <a id="edit-note-link-<?php echo $note->getId() ?>" class="edit-note-link" data-target="<?php echo $note->getId() ?>" href="javascript:void(0);">Editar Anotación »</a>  -->
      <a class="delete-note-link" target="<?php echo $note->getId() ?>" href="javascript:void(0);">Eliminar Anotación »</a>
    </div>
</div>

<div class="separator"></div>