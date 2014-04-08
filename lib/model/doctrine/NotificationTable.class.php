<?php

/**
 * NotificationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NotificationTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object NotificationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Notification');
    }

    public function getUnreadNotificationsForUser($profile_id){
        $query = $this->createQuery('n')
                    ->innerJoin("n.Profile p")
                    ->innerJoin("n.NotificationAction na")
                    ->leftJoin("na.Profile p2")
                    ->where('n.clicked_at IS NULL')
                    ->andWhere("n.seen !=1")
                    ->andWhere("p.id = ?", $profile_id )
                    ->orderBy('n.created_at desc')
                    ->useResultCache(true, null, CacheHelper::getInstance()->genKey('Notification_getUnread', array($profile_id)) );

        return $query->execute();
    }

    public function getUnreadNotificationsCountForUser($profile_id){
        $query = $this->createQuery('n')
                    ->select('count(*)')
                    ->innerJoin("n.Profile p")
                    ->andWhere("n.seen IS NULL")
                    ->andWhere("p.id = ?", $profile_id )
                    ->orderBy('n.created_at desc')
                    ->useResultCache(true, null, CacheHelper::getInstance()->genKey('Notification_getUnreadCount', array($profile_id)) );

        return $query->execute( array(), doctrine::HYDRATE_SINGLE_SCALAR );
    }

    public function getNotificationsForUser($profile_id,$limit=null,$last_id=null){
        $query = $this->createQuery('n')
                    ->innerJoin("n.Profile p")
                    ->innerJoin("n.NotificationAction na")
                    ->leftJoin("na.Profile p2")
                    ->where("p.id = ?", $profile_id )
                    ->useResultCache(true, null, CacheHelper::getInstance()->genKey('Notification_getAll', array($profile_id,$limit,$last_id)) );;

        if($limit){
            $query->limit($limit);
        }

        if($last_id){
            $query->andWhere("n.id > ?",$last_id)
                  ->orderBy('n.created_at asc');
        }else{
            $query->orderBy('n.created_at desc');
        }

        return $query->execute();
    }
}