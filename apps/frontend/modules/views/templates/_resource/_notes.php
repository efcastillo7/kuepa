<?php use_helper('Date') ?>

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