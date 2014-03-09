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
    
    public function add($profile_id, $idResource, $idLesson, $idChapter, $idCourse ) {
                                
        $pccss = ProfileComponentCompletedStatus::getRepository()
                            ->createQuery("pccs")
                            ->innerJoin('pccs.Component c')
                            ->leftJoin('c.LearningPath lp ON c.id = lp.child_id')
                            ->where("pccs.profile_id = ?", $profile_id)
                            ->andwhere("(lp.parent_id = ? OR lp.parent_id = ? OR lp.parent_id = ? OR c.id = ?)", array($idLesson, $idChapter, $idCourse, $idCourse))
                            ->execute();
        
        $arrPccs = array();
        foreach ( $pccss as $pccs ) {
            $this->_completed_status[$profile_id][$pccs->getComponentId()] = $pccs->getCompletedStatus();
            $arrPccs[ $pccs->getComponentId() ] = $pccs;
        }
        
        $pccsResource = isset($arrPccs[$idResource]) ? $arrPccs[$idResource] : 0;
        $pccsLesson = isset($arrPccs[$idLesson]) ? $arrPccs[$idLesson] : 0;
        $pccsChapter = isset($arrPccs[$idChapter]) ? $arrPccs[$idLesson] : 0;
        $pccsCourse = isset($arrPccs[$idCourse]) ? $arrPccs[$idLesson] : 0;
                
        $this->doAdd($pccsResource, $idResource, $profile_id);
        $this->doAdd($pccsLesson, $idLesson, $profile_id);
        $this->doAdd($pccsChapter, $idChapter, $profile_id);
        $this->doAdd($pccsCourse, $idCourse, $profile_id);
    }
    
    private function doAdd($pccs, $component_id, $profile_id) {
        
        if ($pccs == null) {
            $pccs = new ProfileComponentCompletedStatus;
            $pccs->setProfileId($profile_id);
            $pccs->setComponentId($component_id);
        }
        
        //if it has childrens discard and replace de $add_completed_status        
        $component = Component::getRepository()->getById($component_id);
        $component_children = $component->getChildren();
        if($component_children->count()>0) {
            $add_completed_status = 0;
            foreach ($component_children as $child) {
                $add_completed_status += $this->getCompletedStatus($profile_id, $child->getId());
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
            $pccs->save();
            
            
            $this->_completed_status[$profile_id][$component_id] = $completed_status;            
        }
    }


    public function getCompletedStatus($profile_id, $component_id) {
        if( isset( $this->_completed_status[$profile_id][$component_id] ) ) {
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
        
        if ( $pccss ) {
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
