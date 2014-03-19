<?php
class ProfileComponentCompletedStatusService {

    private static $instance = null;
    private $_completed_status = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ProfileComponentCompletedStatusService;
        }

        return self::$instance;
    }
    
    public function add($profile, $resource, $lesson, $chapter, $course ) {
                                
        $pccss = ProfileComponentCompletedStatus::getRepository()
                            ->createQuery("pccs")
                            ->innerJoin('pccs.Component c')
                            ->leftJoin('c.LearningPath lp ON c.id = lp.child_id')
                            ->where("pccs.profile_id = ?", $profile->getId())
                            ->andwhere("(lp.parent_id = ? OR lp.parent_id = ? OR lp.parent_id = ? OR c.id = ?)", array($lesson->getId(), $chapter->getId(), $course->getId(), $course->getId()))
                            ->execute();
        
        $arrPccs = array();
        
        foreach ( $pccss as $pccs ) {
            $this->_completed_status[$profile->getId()][$pccs->getComponentId()] = $pccs->getCompletedStatus();
            $arrPccs[ $pccs->getComponentId() ] = $pccs;
        }
        
        $pccsResource = isset($arrPccs[$resource->getId()]) ? $arrPccs[$resource->getId()] : 0;
        $pccsLesson = isset($arrPccs[$lesson->getId()]) ? $arrPccs[$lesson->getId()] : 0;
        $pccsChapter = isset($arrPccs[$chapter->getId()]) ? $arrPccs[$chapter->getId()] : 0;
        $pccsCourse = isset($arrPccs[$course->getId()]) ? $arrPccs[$course->getId()] : 0;
        
        //ComponentService::getInstance()->addCompletedStatus( $components, $profile );
        
        $this->doAdd($pccsResource, $resource, $profile);
        $this->doAdd($pccsLesson, $lesson, $profile);
        $this->doAdd($pccsChapter, $chapter, $profile);    
        $this->doAdd($pccsCourse, $course, $profile);        
            
    }
    
    private function doAdd($pccs, $component, $profile) {
  
            if ($pccs == null) {
                $pccs = new ProfileComponentCompletedStatus;
                $pccs->setProfileId($profile->getId());
                $pccs->setComponentId($component->getId());
            }

            $component_children = $component->getChildren();
            
            ComponentService::getInstance()->addCompletedStatus($component_children, $profile);
        
            if($component_children->count()>0) {
                $add_completed_status = 0;
                foreach ($component_children as $child) {
                    $add_completed_status += $child->getCacheCompletedStatus();
                }
                $total = $component_children->count()*100;
                $current_completed_status = 0;
            } else {
                $add_completed_status = 100;
                $total = 100;
                $current_completed_status = ($pccs->getCompletedStatus() == null ? 0 : $pccs->getCompletedStatus());
            }

            $completed_status = (($current_completed_status+$add_completed_status)*100/$total);

            if ($completed_status >= 0 && $completed_status <= 100) {
                $pccs->setCompletedStatus( round($completed_status) );            
                $this->_completed_status[$profile->getId()][$component->getId()] = $completed_status;            
            }
            
            // $completitudIndex = StatsService::getInstance()->getCompletitudIndex($profile->getId(), $component->getId());
            // $pccs->setCompletitudIndex($completitudIndex);

            // $velocityIndex = StatsService::getInstance()->getVelocityIndex($profile->getId(), $component->getId());
            // $pccs->setVelocityIndex( $velocityIndex );

            // $skillIndex = StatsService::getInstance()->getSkillIndex($profile->getId(), $component->getId());
            // $pccs->setSkillIndex( $skillIndex );

            // $persistenceIndex = StatsService::getInstance()->getPersistenceIndex($profile->getId(), $component->getId());
            // $pccs->setPersistenceIndex( $persistenceIndex );

            // $effortIndex = StatsService::getInstance()->getEffortIndex($completitudIndex, $persistenceIndex);
            // $pccs->setEffortIndex( $effortIndex );

            // $efficiencyIndex = StatsService::getInstance()->getEfficiencyIndex($velocityIndex, $skillIndex);
            // $pccs->setEfficiencyIndex( $efficiencyIndex );

            // $learningIndex = StatsService::getInstance()->getLearningIndex($effortIndex, $efficiencyIndex);
            // $pccs->setLearningIndex( $learningIndex );

            // $remainingTime = StatsService::getInstance()->getRemainingTime($profile->getId(), $component->getId());
            // $pccs->setTimeRemaining( ( $remainingTime > 0 ) ? $remainingTime : 0 );

            $pccs->save();
    }


    public function getCompletedStatus($profile_id, $component_id) {
        
        if( gettype($component_id) != "object" && isset( $this->_completed_status[$profile_id][$component_id] ) ) {
            return $this->_completed_status[$profile_id][$component_id];
        }
        
        /* Esta parte de codigo se deja para mantener compatibilidad, pero lo ideal es quitar las llamadas
         * directas a getCompletedStatus cuando se muestra la completitud de varios components en una misma pantalla
         * en favor de agruparlos en una unica llamada
         */        
        
        $pccss = ProfileComponentCompletedStatus::getRepository()
                            ->createQuery("pccs")
                            ->where("pccs.profile_id = ?", $profile_id)
                            ->andwhere("pccs.component_id = ?", $component_id)
                            ->fetchOne();
        
        if ( gettype($component_id) != "object" && $pccss ) {
            $this->_completed_status[$profile_id][$component_id] = $pccss->getCompletedStatus();
            return $pccss->getCompletedStatus();
        }
        
        return 0;
    }
    
    public function getArrayCompletedStatus($component_ids, $profile_id) {
    
        return ProfileComponentCompletedStatus::getRepository()
                        ->createQuery("pccs")
                        ->select('pccs.component_id, pccs.completed_status')
                        ->where("pccs.profile_id = ?", $profile_id)
                        ->andWhereIn("pccs.component_id", $component_ids)
                        ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );   
    }

}