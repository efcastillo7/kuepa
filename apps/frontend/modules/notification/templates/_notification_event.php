<?php
$stWildcards = $notification->getNotificationAction()->getWildcards();
$dcWildcards = htmlspecialchars_decode($stWildcards);
$wildcards = json_decode($dcWildcards);
$term = $notification->getNotificationAction()->getTermKey();
?>

<div class="statement">
    <span class="actor"><?php echo $notification->getNotificationAction()->getProfile()->getFullName(); ?></span>
    <span class="action"><?php echo __($term, '', 'notifications'); ?></span>
</div>
<div class="summary">
    <div class="icon"></div>
    <?php echo $wildcards->title; ?>
</div>
<div class="time">
    <?php echo $notification->getCreatedAt()." ".__("scheduled_for","","notifications")." ".$wildcards->scheduled_for; ?>
</div>