<a id="drop-notifications" href="#" role="button" class="nav-btn nav-btn-ntfc dropdown-toggle" data-toggle="dropdown">
    <i></i>
    <span class="notification-count"><?php echo $count > 0 ? $count : ""; ?></span>
</a>

<div class="dropdown-menu notifications arrow-right-img" role="menu" aria-labelledby="notifications">
    <h5 class="text-orange">Notificaciones</h5>
    <div class="cont-notifications">
    <?php
        foreach ($notifications as $notification):
            $clicked_at = $notification->getClickedAt();
            $params = $notification->getNotificationAction()->getParams();
            $url = url_for($notification->getNotificationAction()->getRouteName());
            $destination_url = $url.(empty($params) ? "" : "?{$params}");
    ?>
        <div class="item <?php echo $notification->getNotificationAction()->getType().($clicked_at ? "" : " not_clicked"); ?>" data-url="<?php echo $destination_url; ?>" data-id="<?php echo $notification->getId(); ?>">
            <?php include_component("notification", "notification_{$notification->getNotificationAction()->getType()}",array("notification" => $notification)); ?>
        </div>
    <?php
        endforeach;
        if(!count($notifications)){
            echo "No hay notificaciones";
        }
    ?>
    </div><!-- /cont-notifications -->
    <div class="cont-button text-center">
        <button class="btn-tiny btn-gray view_all_notifications">Ver todas</button>
    </div>
</div>