<?php use_helper('Date') ?>
<li class="li-note-<?php echo $note->getId()?>">
    <p class="">
        <span id="span-note-<?php echo $note->getId() ?>"><?php echo $note->getContent() ?></span>
        <input id="edit-note-input-<?php echo $note->getId() ?>" class="input_add_note span8 hide" type="text" value="<?php echo $note->getContent() ?>" edit-note-id="<?php echo $note->getId() ?>">
        -
        <a id="edit-note-link-<?php echo $note->getId() ?>" class="edit-note-link" target="<?php echo $note->getId() ?>" href="javascript:void(0);">Editar</a>
        <a class="delete-note-link" target="<?php echo $note->getId() ?>" href="javascript:void(0);">Borrar</a>
    </p>
    <p class="small1 gray2">Dijo <?php echo $note->getProfile()->getNickname() ?> el <?php echo format_date($note->getUpdatedAt(), 'dd/MM/yyyy') ?> a las <?php echo format_date($note->getUpdatedAt(), 'HH:mm') ?>hs</p>
</li> 