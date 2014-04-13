<?php

/**
 * Notification
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    kuepa
 * @subpackage model
 * @author     CristalMedia
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Notification extends BaseNotification {
    public static function getRepository() {
        return Doctrine_Core::getTable('Notification');
    }

    public function preSave($event)   {
        self::clearCache($this->getProfileId());
    }
    
    public function preDelete($event) {
        self::clearCache($this->getProfileId());
    }

    public static function clearCache($profile_id){
    	CacheHelper::getInstance()->delete('Notification_getUnread', array( $profile_id ));
        CacheHelper::getInstance()->delete('Notification_getUnreadCount', array( $profile_id ));
        CacheHelper::getInstance()->delete('Notification_getAll', array( $profile_id ));
        CacheHelper::getInstance()->delete('Notification_getAll', array( $profile_id, 10, null ));
    }

}
