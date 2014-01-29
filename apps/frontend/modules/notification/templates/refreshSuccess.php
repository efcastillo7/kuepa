<input type="hidden" name="notifications_count" value="<?php echo $count; ?>" />
<?php
foreach ($notifications as $notification):
    $clicked_at = $notification->getClickedAt();
    $params     = $notification->getNotificationAction()->getParams();
    $url        = url_for($notification->getNotificationAction()->getRouteName());
    $dest_url   = $url.(empty($params) ? "" : "?{$params}");
?>
<div class="item <?php echo $notification->getNotificationAction()->getType().($clicked_at ? "" : " not_clicked"); ?>" data-url="<?php echo $dest_url; ?>" data-id="<?php echo $notification->getId(); ?>">
    <?php include_component("notification", "notification_{$notification->getNotificationAction()->getType()}",array("notification" => $notification)); ?>
</div>
<?php
endforeach;