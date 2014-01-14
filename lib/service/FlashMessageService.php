<?php

class FlashMessageService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new FlashMessageService;
        }

        return self::$instance;
    }

    public function getMessagesForUser($profile_id, $count = null){
        //get all messages 
        $q = FlashMessage::getRepository()->createQuery('fm')
                ->where('fm.id not in (select flash_message_id from profile_view_flash_message pvfm where profile_id = ?)', $profile_id)
                ->andWhere('active = true');

        if($count){
            $q->limit($count);
        }

        return $q->execute();
    }

    public function setMessagesAsViewed($profile_id, $flash_message_id){
        $p = new ProfileViewFlashMessage();
        $p->setProfileId($profile_id)
          ->setFlashMessageId($flash_message_id)
          ->save();

        return true;
    }

}
