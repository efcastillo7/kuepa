<?php use_helper('Date') ?>
<li>
    <p class="">
        <?php echo $note->getContent() ?>
    </p>
    <p class="small1 gray2">Dijo <?php echo $note->getProfile()->getNickname() ?> el <?php echo format_date($note->getCreatedAt(), 'dd/MM/yyyy') ?> a las <?php echo format_date($note->getCreatedAt(), 'HH:mm') ?>hs</p>
</li> 