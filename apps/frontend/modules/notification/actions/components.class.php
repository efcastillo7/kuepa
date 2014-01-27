<?php

class notificationComponents extends kuepaComponents {

    public function executeNotifications() {
        if ($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getUser()->getGuardUser()->getProfile();

            //get the first message
            $this->notifications = NotificationsService::getInstance()->getNotificationsForUser($this->profile->getId(),10);
            $this->count = NotificationsService::getInstance()->getUnreadNotificationsCountForUser($this->profile->getId());
        }
    }

    public function executeNotification_event(){
    }

}
