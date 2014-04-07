<?php

class ComponentService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ComponentService;
        }

        return self::$instance;
    }
        
    public function setDeadlineForUser($profile_id, $component_id, $date){
        $date = is_int($date) ? date('Y-m-d', $date) : $date;

        $plp = ProfileLearningPath::getRepository()->createQuery('plp')
                ->where('profile_id = ? and component_id = ?', array($profile_id, $component_id))
                ->fetchOne();

        if($plp == null){
            $plp = new ProfileLearningPath;
            $plp->setProfileId($profile_id)
                ->setComponentId($component_id);
        }

        $plp->setDeadline($date)
            ->save();

        return;
    }

    public function getDeadlineForUser($profile_id, $component_id){
        //check if user has college
        $deadline = null;

        if($profile_id){
            //check if user has a deadline
            $plp = ProfileLearningPath::getRepository()->createQuery('plp')
                        ->where('profile_id = ? and component_id = ?', array($profile_id, $component_id))
                        ->fetchOne();

            if($plp){
                $deadline = $plp->getDeadline();
            }

            //if deadline is null
            if($deadline == null){
                $college = CollegeService::getInstance()->getByProfileId( $profile_id );

                if($college){
                    $clp = CollegeLearningPath::getRepository()->createQuery('clp')
                        ->where('component_id = ? and college_id = ?', array($component_id, $college->getId()))
                        ->fetchOne();

                    if($clp){
                        $deadline = $clp->getDeadline();
                    }
                }
            }
        }

        return $deadline;
    }

    //mixed $components_ids
    public function getComponents($components_ids){
        $query = Component::getRepository()->createQuery('c');

        if(is_array($components_ids) && count($components_ids)){
            $query->whereIn('id', $components_ids);
        }else{
            $query->where('id = ?',$components_ids);
        }

        return $query->execute();
    }

    public function getArrayComponents($components_ids){
        $query = Component::getRepository()->createQuery('c');

        if(is_array($components_ids) && count($components_ids)){
            $query->whereIn('id', $components_ids);
        }else{
            $query->where('id = ?',$components_ids);
        }

        return $query->fetchArray();
    }

    public function getEnabledCoursesForUser($profile){
        $courses = array();

        if($profile){
            //get Courses for that user
            $colleges = null; //fetch all colleges
            $get_status = array(ProfileLearningPath::IN_PROGRESS);

            $courses = Course::getRepository()->getCoursesForUser($profile->getId(), $colleges, $get_status);
        }

        return $courses;
    }

    public function getCoursesForUser($profile) {
        $courses = array();

        if($profile){
            $colleges = $profile->getColleges();

            //if it has colleges then add them
            foreach ($colleges as $college) {
                $show_status = explode(",", $college->getShowStatus());

                //get Courses for that user if available
                if(!count($show_status) || in_array(ProfileLearningPath::ALL, $show_status)){
                    $courses = Course::getRepository()->getCoursesForCollege($college->getId());
                }else if (count($show_status)){
                    $courses = Course::getRepository()->getCoursesForUser($profile->getId(), $college->getId(), $show_status);
                }
            }
        }

        return $courses;
    }

    public function create($type, $values = array()) {
        //default values
        $def_values = array(
            'name' => '',
            'thumbnail' => '',
            'description' => '',
            'level' => '',
            'duration' => 0,
            'node_id' => null
        );
        //merge values
        $values = $values + $def_values;

        //TODO: check for uncosistent

        $component = new Component();
        $component->setName($values['name'])
                ->setThumbnail($values['thumbnail'])
                ->setDescription($values['description'])
                ->setLevel($values['level'])
                ->setProfileId($values['profile_id'])
                ->setDuration($values['duration'])
                ->setType($type)
                ->setNodeId($values['node_id'])
                ->save();

        // Update Duration when create a child $type
        ComponentService::getInstance()->updateDuration( $component->getId() );

        return $component;
    }

    public function edit($component_id, $values = array()) {
        $component = Component::getRepository()->getById($component_id);

        if ($component) {
            //editable fields
            $values_keys = array('name', 'thumbnail', 'description', 'level', 'profile_id', 'duration');

            foreach ($values_keys as $key) {
                //check if loaded
                if (isset($values[$key])) {
                    $component->set($key, $values[$key]);
                }
            }

            // Update Duration when edit a child $type
            ComponentService::getInstance()->updateDuration( $component->getId() );

            $component->save();
        }

        return $component;
    }

    public function delete($component_id) {
        $component = Component::getRepository()->getById($component_id);

        if ($component) {
            $component->delete();
        }

        return;
    }

    public function addUserToComponent($component_id, $user_id) {
        $plp = new ProfileLearningPath();

        try {
            $plp->setProfileId($user_id)
                ->setComponentId($component_id)
                ->setProfileLearningPathStatusId(ProfileLearningPath::IN_PROGRESS)
                ->save();
        } catch (Exception $e) {
            
        }

        //exception?
        return;
    }

    public function removeUserFromComponent($component_id, $user_id) {
        $plp = ProfileLearningPath::getRepository()->findByComponentIdAndProfileId($component_id, $user_id);

        if ($plp) {
            $plp->delete();
        }

        return;
    }

    public function setComponentStatus($parent_id, $child_id) {
        //get position child
        $child = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $parent_id)
                ->andWhere('lp.child_id = ?', $child_id)
                ->limit(1)
                ->fetchOne();

        //if exists
        if ($child) {
            $child->setEnabled(1 - $child->getEnabled());
            $child->save();

            return true;
        }

        return false;
    }

    public function getUsersFromComponent($component_id, $type = 1, $deep = false) {
        //type for the time beeing is dummy, will be Student, Teacher, Head, etc.

        $q = Profile::getRepository()->createQuery('p')
                ->innerJoin('p.ProfileLearningPath plp')
                ->where('plp.component_id = ?', $component_id);
        // ->andWhere('plp.type = ?','e') //type of profile
        //deep is set to check all tree users like "college users"

        return $q->execute();
    }

    public function getCountChilds($component_id, $type = null) {
        //TODO: check orderBy parameter SQLINJ

        $q = Component::getRepository()->createQuery('child')
                ->select('count(child.id) as total')
                ->innerJoin('child.LearningPath lp ON child.id = lp.child_id')
                ->where('lp.parent_id = ?', $component_id);

        if ($type) {
            $q->andWhere('child.type = ? ', $type);
        }

        //execute query
        $r = $q->fetchOne();

        if($q){
            return $r->getTotal();;
        }        

        return 0;
    }

    public function getChilds($component_id, $type = null, $orderBy = 'asc', $onlyEnabled = false) {
                        
        $orderBy = DQLHelper::getInstance()->parseOrderBy($orderBy);

        $q = Component::getRepository()->createQuery('c')
                ->select('c.*, lp.*')
                ->innerJoin('c.LearningPath lp ON c.id = lp.child_id')
                ->where('lp.parent_id = ?', $component_id)
                ->orderBy("lp.position $orderBy");

        if ($type) {
            $q->andWhere('c.type = ? ', $type);
        }
        
        if ($onlyEnabled) {
            $q->andWhere("lp.enabled = true");
        }
        
        // Gestion de Cache
        $cacheParams = array();
        $cacheParams[] = $component_id;
        $cacheParams[] = (string ) $type;
        $cacheParams[] = $orderBy;
        $cacheParams[] = (int) $onlyEnabled;
        
        $q->useResultCache(true, null, cacheHelper::getInstance()->genKey('Component_getChilds', $cacheParams ) );
        
        return $q->execute();
    }

    public function getLastChildPosition($component_id) {
        $q = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $component_id)
                ->orderBy('lp.position desc')
                ->limit(1)
                ->fetchOne();

        if ($q) {
            return $q->getPosition();
        }

        return 0;
    }

    public function addChildToComponent($parent_id, $child_id) {
        //get last item from parent
        $position = self::getInstance()->getLastChildPosition($parent_id) + 1;

        $lp = new LearningPath();
        $lp->setParentId($parent_id)
                ->setChildId($child_id)
                ->setPosition($position)
                ->save();

        return;
    }

    public function getChildPosition($parent_id, $child_id) {
        $child = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $component_id)
                ->andWhere('lp.child_id = ?', $child_id)
                ->limit(1)
                ->fetchOne();

        if ($child) {
            return $child->getPosition();
        }

        return null;
    }

    public function removeChildFromComponent($parent_id, $child_id) {
        //get position child
        $child = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $parent_id)
                ->andWhere('lp.child_id = ?', $child_id)
                ->limit(1)
                ->fetchOne();

        //if exists
        if ($child) {
            //get position to update order
            $position = $child->getPosition();
            //remove
            $child->delete();
            //update next positions
            $q = LearningPath::getRepository()->createQuery('lp')
                    ->update()
                    ->set('position', '(position - 1)')
                    ->where('parent_id = ?', $parent_id)
                    ->andWhere('position > ?', $position)
                    ->execute();

            return true;
        }

        return false;
    }

    public function reOrderComponentChildren($parent_id, $children_hash) {
        //children hash must be: key -> learning_path position, value -> existing child component
        foreach ($children_hash as $position => $child_component) {

            $lp = LearningPath::getRepository()->createQuery('lp')
                    ->where('lp.parent_id = ?', $parent_id)
                    ->andWhere('lp.child_id = ?', $child_component->getId())
                    ->limit(1)
                    ->fetchOne();

            if ($lp == null) {
                $lp = new LearningPath();
                $lp->setParentId($parent_id);
                $lp->setChildId($child_component->getId());
            }

            $lp->setPosition($position);
            $lp->save();
        }
    }

    public function getNoteAvg($profile_id, $component_id){
        //this is the note avg of all resources, including the exercices
        $avg_notes = ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($profile_id, $component_id);

        return  $avg_notes/100;
    }

    public function getCountExerciseTryouts($profile_id, $component_id, $from_note = 0){
        //
        $component = Component::getRepository()->getById($component_id);

        if($component->getType() != "Lesson"){
            //
        }else{
            $query = "SELECT lp.child_id FROM LearningPath lp WHERE lp.parent_id = $component_id";

            $q = ExerciseAttemp::getRepository()->createQuery('ea')
                    ->select("count(*) as total")
                ->innerJoin('ea.ResourceData rd ON ea.exercise_id = CAST(rd.content as UNSIGNED)')
                    ->where('rd.type = ?', 'Exercise')
                    ->andWhere('ea.value >= ?', $from_note)
                    ->andWhere("rd.resource_id in ($query)");

            $total = $q->fetchOne();

            if($total){
                return  $total->getTotal();
            }

            return 0;
            
        }

    }    

    public function getParents($component_id, $orderBy = 'asc'){

        $q = Component::getRepository()->createQuery('parent')
                ->select('parent.*')
                ->innerJoin('parent.LearningPath lp ON parent.id = lp.parent_id')
                ->where('lp.child_id = ?', $component_id)
                ->orderBy("lp.position $orderBy");
        $parents = $q->execute();
        return $parents;
    }

    public function calculateTime($component_id){
       /* SELECT SUM(c.duration)
        FROM  component c JOIN learningpath lp ON c.id=lp.child_id
        WHERE lp.parent_id = ? component_id */        

        $q = Component::getRepository()->createQuery('child')
                ->select('SUM(child.duration) as duration')
                ->innerJoin('child.LearningPath lp ON child.id = lp.child_id')
                ->where('lp.parent_id = ?', $component_id);
        $q = $q->fetchOne();

        return $q->getDuration();
    }

    /**
    * update de duration recursively. Courses, chapters and lessons
    */
    public function updateDuration($component_id)
            {

        $component = Component::getRepository()->getById($component_id);
        if ( $component->getType() == Resource::TYPE  ){ // Resource
            $duration = $component->calculateTime();
        }else{
            $duration = ComponentService::getInstance()->calculateTime($component_id);
        }        
        $component->setDuration($duration);
        $component->save();
 
        $parents = $component->getParents();

        if ( count($parents) > 0  ){
            foreach ($parents as $key => $parent) {                
                ComponentService::getInstance()->updateDuration($parent->getId());
            }
        } 
    }
    
    public function addCompletedStatus($components, $profile = null, $completedStatusData = null)
    {
        if(!$completedStatusData){
            $components_ids = array();
            foreach( $components as $component )
            {
                $components_ids[] = $component->getId();
            }
        
            $completedStatusData = ProfileComponentCompletedStatusService::getInstance()->getArrayCompletedStatus($components_ids, $profile->getId());
        }
        
        foreach( $components as $component )
        {
            $completedStatus = ( isset( $completedStatusData[ $component->getId() ] ) ) ? $completedStatusData[ $component->getId() ] : 0;            
            $component->setCacheCompletedStatus( $completedStatus, $profile->getId() );
        }
        
        return $components;
    }
    

    public function getCountResources($component_id){
        $q = ViewLearningPath::getRepository()->createQuery('vlp')
             ->select('COUNT(vlp.course_id) as total');
        $component = Component::getRepository()->getById($component_id);

        switch ( $component->getType() ) {
             case Course::TYPE:
                 $q = $q -> where('course_id = ? ',$component_id);
                 break;
             case Chapter::TYPE:
                 $q = $q -> where('chapter_id = ? ',$component_id);
                 break;
             case Lesson::TYPE:
                 $q = $q -> where('lesson_id = ? ',$component_id);
                 break;
             default:
                 # code...
                 break;
         } 

        $q = $q->fetchOne();

         return($q->getTotal());

    }

}
