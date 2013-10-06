<?php

class LogService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new LogService;
        }

        return self::$instance;
    }

    public function access($profile_id){
        //add new access
        $log = new LogAccess();
        $log->setProfileId($profile_id)
            ->save();

        return;
    }

    public function viewResource($type, $component_id, $profile_id){
        //search for current log for update
        $time = time();
        $time_window = Date('Y-m-d H:i:s', $time - sfConfig::get("app_log_window"));

        $last = LogViewComponent::getRepository()->createQuery('lvc')
                ->where('updated_at >= ?', "$time_window")
                ->andWhere('type = ? and profile_id = ?', array($type, $profile_id))
                ->orderBy('updated_at desc')
                ->limit(1)
                ->fetchOne();

        //if exists and is at the same place
        if($last && $last->component_id == $component_id){
            $last->setUpdatedAt(Date('Y-m-d H:i:s', $time))
                 ->save();
            return $last;
        }

        //otherwise create
        $log = new LogViewComponent();
        $log->setType($type)
            ->setComponentId($component_id)
            ->setProfileId($profile_id)
            ->save();

        return $last;
    }

    public function getFirstAccess($profile_id, $course_id = null){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->where("profile_id = ?", $profile_id)
                ->orderBy('created_at asc')
                ->limit(1);

        $var = $q->fetchOne();

        if($var){
            return $var->getCreatedAt();
        }

        return null;
    }

    public function getLastAccess($profile_id){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->where("profile_id = ?", $profile_id)
                ->orderBy('created_at desc')
                ->limit(1)
                ->fetchOne();

        if($q){
            return $q->getCreatedAt();
        }

        return null;
    }

    public function getTotalTime($profile_id){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->select("sum(updated_at - created_at) as total")
                ->where("profile_id = ?", $profile_id)
                ->fetchOne();

        if($q){
            return $q->getTotal();
        }

        return null;
    }

    public function getTotalRecourseViewed($profile_id){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->select("distinct(component_id)")
                ->where("profile_id = ?", $profile_id)
                ->execute();

        if($q){
            return $q->count();
        }

        return 0;
    }
}
