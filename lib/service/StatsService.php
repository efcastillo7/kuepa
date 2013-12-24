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

        return $component_duration / $invest_time;
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
        
        return ($childs_total*$exercise_count_approved) / ($childs_viewed * $exercise_count);

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

    
    

}
