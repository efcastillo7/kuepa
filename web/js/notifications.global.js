var int_notifications;

$(function() {

    //Shows the notifications and marks them as read
    $("#drop-notifications").click(function(e) {

        var $notificationCount = $(".notification-count");

        if ($notificationCount.text() == "") {
            return true;
        }

        //Sets all notifications as read
        $.getJSON("notification/set_seen", function(data) {
            //Hides the counter
            $notificationCount.hide(100);

            //Logs the result
            if (window.console) {
                console.log(data.template);
            }
        });

    });

    //Opens a notification and marks it as interacted
    $(".cont-notifications .item, .notifications-list .notification").on("click",function() {
        var $notification = $(this);

        if ($notification.is(".not_clicked")) {
            //Marks the notification as interacted, and redirects
            $.getJSON("notification/set_interacted", {id: $notification.attr("data-id")}, function(data) {
                //Hides the counter
                location.href = $notification.attr("data-url");

                //Logs the result
                if (window.console) {
                    console.log(data.template);
                }
            });
        } else {
            location.href = $notification.attr("data-url");
        }

    });

    $(".view_all_notifications").click(function(){
       location.href="/notification";
    });

    //Starts the update interval
    refreshNotifications();
});

/**
 *
 * @returns {undefined}
 */
function refreshNotifications() {

    var $lastItem           = $(".cont-notifications .item:first");
    var $contNotifications  = $(".dropdown-menu.notifications .cont-notifications");
    var $notifticationCount = $(".notification-count");
    var data = {
        last_id: $lastItem.attr("data-id"),
        count: 10
    };

    //post and process json response
    $.ajax('/notification/refresh',{
        dataType: 'json',
        type: 'post',
        data: data,
        success: function(data){
            //avoid preprending multiple responses
            var count = data.count;

            if(count > 0){
                $notifticationCount.text(count).show();
                
                //add notifications
                $contNotifications.prepend($(data.template));
            }else{
                $notifticationCount.text("").hide();
            }

            int_notifications = setTimeout(refreshNotifications,5000);
        }
    });
}