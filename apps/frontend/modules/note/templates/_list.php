<?php use_helper('Date') ?>

<div class="notes">
    <p class="title5">Anotaciones</p>
    <input class="span8" type="text" placeholder="Escribe un recordatorio para esta lección...">
    <ul class="unstyled">
        <?php foreach($notes as $note): ?>
        <li>
            <p class="">
                <?php echo $note->getContent() ?>
            </p>
            <p class="small1 gray2"><?php echo format_date($note->getCreatedAt(), 'yyyy/MM/dd mm:ss') ?>hs</p>
        </li> 
        <?php endforeach; ?>
    </ul>
</div>