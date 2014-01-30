<?php
$stWildcards = $notification->getNotificationAction()->getWildcards();
$dcWildcards = htmlspecialchars_decode($stWildcards);
$wildcards = json_decode($dcWildcards);
$term = $notification->getNotificationAction()->getTermKey();
?>

<h2>
<a href="#"><span class="name"><?php echo $notification->getNotificationAction()->getProfile()->getFullName(); ?></span></a>
<span><?php echo __($term, '', 'notifications'); ?>:</span>
</h2>
<div class="left">
<i class="spr ico-notification-calendar"></i>
</div>
<div class="">
<a href="#">
  <span class="text"><?php echo $wildcards->title; ?></span>
  <span class="time"><?php echo $notification->getCreatedAt()." ".__("scheduled_for","","notifications")." ".$wildcards->scheduled_for; ?></span>
</a>
</div>