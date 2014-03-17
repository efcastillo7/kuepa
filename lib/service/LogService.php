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

    public function viewResource($profile_id, $type, $course_id, $chapter_id, $lesson_id, $resource_id){
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
        if($last && 
            $last->resource_id == $resource_id && 
            $last->lesson_id == $lesson_id &&
            $last->chapter_id == $chapter_id && 
            $last->course_id == $course_id){
            
            $lastPCCS = ProfileComponentCompletedStatus::getRepository()->createQuery('pccs')
                 ->where('time_view >= ?', $time - sfConfig::get("app_log_window"))
                 ->andWhere('profile_id = ?', $profile_id)
                 ->orWhere('component_id = ?', $last->resource_id)
                 ->orWhere('component_id = ?', $last->lesson_id)
                 ->orWhere('component_id = ?', $last->chapter_id)
                 ->orWhere('component_id = ?', $last->course_id)
                 ->execute();

            foreach ($lastPCCS as $pccs){
                $pccs->setTimeView($pccs->getTimeView() + ($time - strtotime($last->getUpdatedAt())))
                     ->save();
            }
            
            $last->setUpdatedAt(Date('Y-m-d H:i:s', $time))
                 ->save();
            
            return $last;
        }
        
        //otherwise create
        $log = new LogViewComponent();
        $log->setType($type)
            ->setCourseId($course_id)
            ->setChapterId($chapter_id)
            ->setLessonId($lesson_id)
            ->setResourceId($resource_id)
            ->setProfileId($profile_id)
            ->save();
        
        return $last;
    }

    public function getFirstAccess($profile_id, $course_id = null, $chapter_id = null, $lesson_id = null, $resource_id = null){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->where("profile_id = ?", $profile_id)
                ->orderBy('created_at asc')
                ->limit(1);

        if($course_id){
            $q->andWhere("course_id = ?", $course_id);
        }

        if($chapter_id){
            $q->andWhere("chapter_id = ?", $chapter_id);
        }

        if($lesson_id){
            $q->andWhere("lesson_id = ?", $lesson_id);
        }

        if($resource_id){
            $q->andWhere("resource_id = ?", $chapter_id);
        }

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

    public function getTotalTime($profile_id, $component = null, $from_date = null, $to_date = null){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->select("sum(updated_at - created_at) as total")
                ->where("profile_id = ?", $profile_id);

        if($from_date){
            $q->andWhere("created_at >= ?", date("Y-m-d", $from_date));
        }

        if($to_date){
            $q->andWhere("created_at < ?", date("Y-m-d", $to_date));
        }

        $type = $component->getType();

        switch ($type) {
            case Course::TYPE:
                $parent_id = $component->getId();
                $chapters = "select child_id from learning_path lp1 where parent_id = $parent_id";
                $lessons = "select child_id from learning_path lp2 where parent_id in ($chapters)";
                $resources = "select child_id from learning_path lp3 where parent_id in ($lessons)";
                break;
            case Chapter::TYPE:
                $parent_id = $component->getId();
                $lessons = "select child_id from learning_path lp2 where parent_id in ($parent_id)";
                $resources = "select child_id from learning_path lp3 where parent_id in ($lessons)";
                break;

            case Lesson::TYPE:
                $parent_id = $component->getId();
                $resources = "select child_id from learning_path lp3 where parent_id in ($parent_id)";
                break;

            case Resource::TYPE:
                $resources = $component->getId();
                break;
            
            default:
                $resources = $component->getId();
                break;
        }

        if($component){
            $q->andWhere("lvc.resource_id in ($resources)");
        }

        $q = $q->fetchOne();

        if($q){
            return $q->getTotal();
        }

        return 0;
    }

    public function getLastResourceIdViewed($profile_id, $component = null){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->where('lvc.profile_id = ?', $profile_id)
                ->limit(1)
                ->orderBy('lvc.created_at desc');

        //check type
        if($component instanceof Course){
            //if course then get all chapters
            $parent_id = $component->getId();
            $chapters = "select child_id from learning_path lp1 where parent_id = $parent_id";
            $lessons = "select child_id from learning_path lp2 where parent_id in ($chapters)";
            $resources = "select child_id from learning_path lp3 where parent_id in ($lessons)";
        }else if($component instanceof Chapter){
            $parent_id = $component->getId();
            $lessons = "select child_id from learning_path lp2 where parent_id in ($parent_id)";
            $resources = "select child_id from learning_path lp3 where parent_id in ($lessons)";
        }else if($component instanceof Lesson){
            $parent_id = $component->getId();
            $resources = "select child_id from learning_path lp3 where parent_id in ($parent_id)";
        }else if($component instanceof Resource){
            //nothing to do
            $resources = $component->getId();
        }
        //add more

        $q->andWhere("lvc.resource_id in ($resources)");

        return $q->fetchOne();

    }

    /** TODO: This method should be removed */
    public function getTotalRecourseViewed($profile_id, $component_id = null, $unique = false){
        //query
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->where("profile_id = ?", $profile_id);

        if($unique){
            $q->select("count(distinct(resource_id)) as count");
        }else{
            $q->select("count(resource_id) as count");
        }

        //if there is a component so get its childs
        // it is not working if the parent is a chapter or course
        // also, this can be removed bacause course_id,chapter_id and lesson_id were added
        /*if($component_id){ 
            $q->andWhere('lvc.resource_id in (select child_id from learning_path lp where parent_id = ?)', $component_id);
        }*/
        if($component_id){ 
            $component = Component::getRepository()->getById($component_id);
            switch ( $component->getType() ) {
                 case Course::TYPE:
                     $q = $q -> andWhere('course_id = ? ',$component_id);
                     break;
                 case Chapter::TYPE:
                     $q = $q -> andWhere('chapter_id = ? ',$component_id);
                     break;
                 case Lesson::TYPE:
                     $q = $q -> andWhere('lesson_id = ? ',$component_id);
                     break;
                 default:
                     # code...
                     break;
             } 
        }
        //execute query
        $r = $q->fetchOne();

        if($r){
            return $r->getCount();
        }

        return 0;
    }

    public function getLastViewedResources($profile_id, $date_from = null, $date_to = null, $count = null ){
        $q = LogViewComponent::getRepository()->createQuery('lvc')
                ->innerJoin("lvc.Resource r")
                ->where('lvc.profile_id = ?', $profile_id)
                // ->andWhere("(lvc.updated_at - lvc.created_at) > 5")
                // ->limit(20)
                ->orderBy('lvc.created_at desc');

        if($count){
            $q->limit($count);
        }

        if($date_from){
            $q->andWhere('lvc.created_at > ?', date("Y-m-d H:i:s", $date_from));
        }

        if($date_to){
            $q->andWhere('lvc.created_at < ?', date("Y-m-d H:i:s", $date_to));
        }        

        return $q->execute();
    }
}
