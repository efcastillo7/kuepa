<?php

class NotificationsService {

    /**
     * The instance
     * @var NotificationsService
     */
    private static $instance = null;

    /**
     *
     * @return NotificationsService
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new NotificationsService;
        }

        return self::$instance;
    }

    /**
     *
     * @param (int|string) $profile_id
     * @return Doctrine_Collection
     */
    public function getUnreadNotificationsForUser($profile_id,$limit=null){
        $query = Notification::getRepository()->createQuery('n')
                    ->innerJoin("n.Profile p")
                    ->innerJoin("n.NotificationAction na")
                    ->leftJoin("na.Profile p2")
                    ->where('n.clicked_at IS NULL')
                    ->andWhere("n.seen !=1")
                    ->andWhere("p.id = ?", $profile_id )
                    ->orderBy('n.created_at desc')
                    ->limit($limit);

        return $query->execute();
    }

    /**
     *
     * @param (int|string) $profile_id
     * @return Doctrine_Collection
     */
    public function getUnreadNotificationsCountForUser($profile_id){
        $query = Notification::getRepository()->createQuery('n')
                    ->innerJoin("n.Profile p")
                    ->andWhere("n.seen IS NULL")
                    ->andWhere("p.id = ?", $profile_id )
                    ->orderBy('n.created_at desc');

        return count($query->execute());
    }

    /**
     *
     * @param (int|string) $profile_id
     * @return Doctrine_Collection
     */
    public function getNotificationsForUser($profile_id,$limit=null,$last_id=null){
        $query = Notification::getRepository()->createQuery('n')
                    ->innerJoin("n.Profile p")
                    ->innerJoin("n.NotificationAction na")
                    ->leftJoin("na.Profile p2")
                    ->where("p.id = ?", $profile_id );

        if(!empty($limit)){
            $query->limit($limit);
        }

        if(!empty($last_id)){
            $query->andWhere("n.id > ?",$last_id)
                  ->orderBy('n.created_at asc');
        }else{
            $query->orderBy('n.created_at desc');
        }

        return $query->execute();
    }

    /**
     *
     * @param string $profile_id
     * @param string $message_id
     * @param int $read
     * @return NotificationsService
     */
    public function markNotificationAsRead($profile_id, $notification_id, $read = 1){
        //update flag
        Notification::getRepository()->createQuery('mr')
            ->update()
            ->set('seen', $read)
            ->where('id = ?', $notification_id)
            ->andWhere('profile_id = ?', $profile_id)
            ->execute();

        return $this;
    }

    /**
     *
     * @param string $profile_id
     * @param string $message_id
     * @param int $read
     * @return NotificationsService
     */
    public function markAllNotificationsAsRead($profile_id, $read = 1){
        //update flag
        Notification::getRepository()->createQuery()
            ->update()
            ->set('seen', $read)
            ->where('profile_id = ?', $profile_id)
            ->execute();

        return $this;
    }

    /**
     * Creates a video session notification
     * @param string $videoSessionId
     * @return boolean
     */
    public function addVideoSessionNotification($videoSessionId){

        //Gets the video session data
        $videoSession = VideoSession::getRepository()->find($videoSessionId);

        if(!$videoSession){
            return false;
        }

        //Persists the notification action
        $notificationAction = new NotificationAction();
        $notificationAction
                ->setProfile($videoSession->getProfile())
                ->setTermKey("video_session_added")
                ->setRouteName("video_session")
                ->setType("event")
                ->setWildcards(json_encode(
                    array(
                        "title"         => $videoSession->getTitle(),
                        "scheduled_for" => $videoSession->getScheduledFor()
                    )
                ))
                ->save();

        //And the notifications for each user
        $profiles = VideoSessionService::getInstance()->getEnabledProfiles($videoSessionId);

        foreach($profiles as $profile){
            $notification = new Notification();
            $notification
                ->setNotificationAction($notificationAction)
                ->setProfileId($profile)
                ->save();
        }
    }

}
