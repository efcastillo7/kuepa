
<div class="container">
    <h2>Notificaciones (<?php echo $count; ?>)</h2>
    <div class="notifications-list">
        <?php
        foreach ($notifications as $notification):
            $clicked_at = $notification->getClickedAt();
            $params = $notification->getNotificationAction()->getParams();
            $url = url_for($notification->getNotificationAction()->getRouteName());
            $destination_url = $url . (empty($params) ? "" : "?{$params}");
            ?>
            <div class="notification <?php echo $notification->getNotificationAction()->getType() . ($clicked_at ? "" : " not_clicked"); ?>" data-url="<?php echo $destination_url; ?>" data-id="<?php echo $notification->getId(); ?>">
                <?php include_component("notification", "notification_{$notification->getNotificationAction()->getType()}", array("notification" => $notification)); ?>
            </div>
            <?php
        endforeach;
        if (!count($notifications)) {
            echo "No hay notificaciones";
        }
        ?>
    </div>
</div>