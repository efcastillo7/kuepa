<?php use_helper('Date') ?>

<div class="box-annotations">
    <div class="wrap wrap-arrow-gray">
      <i class="spr ico-annotations"></i>
    </div>
    <div class="data">
      <input id="edit-note-input-<?php echo $note->getId() ?>" class="input_add_note span8 hide" type="text" value="<?php echo $note->getContent() ?>" edit-note-id="<?php echo $note->getId() ?>">
      <p class="annotation">
        <?php echo $note->getContent() ?>
      </p>
      <p class="date">
        <?php echo format_date($note->getUpdatedAt(), 'dd/MM/yyyy') ?> a las <?php echo format_date($note->getUpdatedAt(), 'HH:mm') ?>hs
      </p>
      <!-- <a href="#">Editar Anotación »</a> -->
    </div>
</div>

<div class="separator"></div>