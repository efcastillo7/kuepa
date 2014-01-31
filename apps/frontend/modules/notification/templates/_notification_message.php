<?php
$stWildcards = $notification->getNotificationAction()->getWildcards();
$dcWildcards = htmlspecialchars_decode($stWildcards);
$wildcards = json_decode($dcWildcards);
$term = $notification->getNotificationAction()->getTermKey();
?>

  <h2>
    <span>Mensaje de</span>
    <a href="#"><span class="name"><?php echo $notification->getNotificationAction()->getProfile()->getNickname(); ?></span></a>
  </h2>
  <div class="left">
    <i class="spr ico-notification-message"></i>
  </div>
  <div class="">
    <a href="#">
      <span class="text"><?php echo $wildcards->content; ?></span>
      <span class="time">A las <?php echo $notification->getCreatedAt()?></span>
    </a>
  </div>
