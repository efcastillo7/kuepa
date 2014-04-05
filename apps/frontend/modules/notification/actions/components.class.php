<?php

class notificationComponents extends kuepaComponents {

    public function executeNotifications() {
        if ($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getProfile();

            //get the first message
            $this->notifications = NotificationsService::getInstance()->getNotificationsForUser($this->profile->getId(),10);
            $this->count = NotificationsService::getInstance()->getUnreadNotificationsCountForUser($this->profile->getId());
            // $this->notifications = array();
            // $this->count = 0;
        }
    }

    public function executeNotification_event(){
    }

    public function executeNotification_message(){
    }

}
