<?php

class StatsService {

    private static $instance = null;
    private $_approveBar = 70;
    private $_pond = 0.35;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new StatsService;
        }

        return self::$instance;
    }

    public function getVelocityIndex($profile_id, $component_id){
        //get component
        $component = Component::getRepository()->find($component_id);

        //get invest time
        $invest_time = LogService::getInstance()->getTotalTime($profile_id, $component);
        $component_duration = $component->getDuration();
        $v = 0;
        if( $invest_time > 0 ){
            $v = $component_duration / $invest_time;
        }
        return($v);
    }

    public function getCompletitudIndex($profile_id, $component_id){
        //get count component childs
        $childs_total = ComponentService::getInstance()->getCountChilds($component_id);

        //get how many of that childs was seen
        //IMPORTANT! childs_viewed ALWAYS must be count of resources of that component
        // FE: if that component is a Chapter must return = SUM(count_resources(chapter.lesson))
        // TODO: make it recursive!
        $childs_viewed = LogService::getInstance()->getTotalRecourseViewed($profile_id, $component_id, true);

        //one could return the percentage of the ProfileComponentCompletedStatus
        return $childs_viewed / $childs_total;
    }

    public function getSkillIndex($profile_id, $component_id){
        $note_avg = ComponentService::getInstance()->getNoteAvg($profile_id, $component_id);

        // $childs_viewed = LogService::getInstance()->getTotalRecourseViewed($profile_id, $component_id);

        // return 1 - ($note_avg  / $childs_viewed);

        return $note_avg;

        //TODO:
        //if component is a Chapter then skill is the avg of lesson notes weighted by #resources
        //if component is a Course then skill is the avg of chapter notes weighted by #resources
    }

    public function getPersistenceIndex($profile_id, $component_id){
        //total exercise tryed
        $exercise_count = ComponentService::getInstance()->getCountExerciseTryouts($profile_id, $component_id, 0);
        //get count component childs
        $childs_total = ComponentService::getInstance()->getCountChilds($component_id);
        //total unique childs viewed
        $childs_viewed = LogService::getInstance()->getTotalRecourseViewed($profile_id, $component_id, true);

        //if there are no exercises done
        if($exercise_count > 0){
            //approved exercise
            $exercise_count_approved = ComponentService::getInstance()->getCountExerciseTryouts($profile_id, $component_id, $this->_approveBar);
        }else{
            $exercise_count = $exercise_count_approved = 1;
        }

        if($childs_viewed == 0){
            return 0;
        }

        // return $exercise_count;
        
        //return ("($childs_total*$exercise_count_approved) / ($childs_viewed * $exercise_count) = ".($childs_total*$exercise_count_approved) / ($childs_viewed * $exercise_count));
        return (($childs_total*$exercise_count_approved) / ($childs_viewed * $exercise_count));

    }

    public function getEfficiencyIndex($profile_id, $component_id){
        return $this->getVelocityIndex($profile_id, $component_id) * $this->getSkillIndex($profile_id, $component_id);
    }

    public function getEffortIndex($profile_id, $component_id){
        return $this->getCompletitudIndex($profile_id, $component_id) * $this->getPersistenceIndex($profile_id, $component_id);
    }

    public function getLearningIndex($profile_id, $component_id){
        return $this->getEffortIndex($profile_id, $component_id) * $this->_pond +
                $this->getEfficiencyIndex($profile_id, $component_id) * (1-$this->_pond);
    }

    public function getRemainingTime($profile_id, $component_id){
        $component = Component::getRepository()->find($component_id);

        $time_given = $component->getDuration();

        $time_dedicated = LogService::getInstance()->getTotalTime($profile_id, $component);

        return $time_given - $time_dedicated;
    }

    public function getAvgAdvancePerDay($profile_id, $component_id, $from_date = null, $to_date = null){
        $component = Component::getRepository()->find($component_id);

        if($from_date == null){
            //first access
            $from_date = strtotime(LogService::getInstance()->getFirstAccess($profile_id, $course_id));
        }

        if($to_date == null){
            //now
            $to_date = time();
        }

        $time_dedicated = LogService::getInstance()->getTotalTime($profile_id, $component, $from_date, $to_date) / 3600;
        $days_between = stdDates::day_diff($from_date, $to_date);

        return $time_dedicated / $days_between;
    }

    public function getAvgAdvancePerWeek($profile_id, $component_id, $from_date = null, $to_date = null){
        //avg per day * 7 days
        return $this->getAdvancePerDay($profile_id, $component_id, $from_date, $to_date) * 7;
    }

    public function getRemainingPerWeek($profile_id, $component_id, $from_date = null, $to_date = null){
        $component = Component::getRepository()->find($component_id);

        $remaining = $this->getRemainingTime($profile_id, $component_id);

        if($to_date == null){
            $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $component_id);
            //pass to seconds
            $to_date = strtotime($to_date);
        }

        if($from_date == null){
            $from_date = time();
        }

        $weeks = (stdDates::day_diff($from_date,$to_date) + 1) / 7;

        return $remaining / $weeks;
    }

    public function getRemainingPerDay($profile_id, $component_id, $from_date = null, $to_date = null){
        $component = Component::getRepository()->find($component_id);

        $remaining = $this->getRemainingTime($profile_id, $component_id);

        if($to_date == null){
            $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $component_id);
            //pass to seconds
            $to_date = strtotime($to_date);
        }

        if($from_date == null){
            $from_date = time();
        }

        $days_remaining = stdDates::day_diff($from_date,$to_date);

        return $remaining / $days_remaining;
    }
    

}
