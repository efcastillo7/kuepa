<?php

class ProfileComponentCompletedStatusService {

    private static $instance = null;
    private $_completed_status = null;
    private $_completed_status_cache = 999;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ProfileComponentCompletedStatusService;
        }

        return self::$instance;
    }
    
    public function add($add_completed_status, $profile_id, $component_id, $parent_component_id = null, $paparent_component_id = null, $papaparent_component_id = null) {
        $pccs = ProfileComponentCompletedStatus::getRepository()->createQuery("pccs")
                ->where("pccs.profile_id = ?", $profile_id)
                ->andWhere("pccs.component_id = ?", $component_id)
                ->fetchOne();

        if ($pccs == null) {
            $pccs = new ProfileComponentCompletedStatus;
            $pccs->setProfileId($profile_id);
            $pccs->setComponentId($component_id);
        }
        
        //if it has childrens discard and replace de $add_completed_status
        $component = Component::getRepository()->find($component_id);
        $component_children = $component->getChildren();
        if($component_children->count()>0) {
            $add_completed_status = 0;
            foreach ($component_children as $child) {
                $add_completed_status += $this->getCompletedStatus($profile_id, $child->getId());
            }
            $total = $component_children->count()*100;
            $current_completed_status = 0;
        } else {
            $total = 100;
            $current_completed_status = ($pccs->getCompletedStatus() == null ? 0 : $pccs->getCompletedStatus());
        }

        $completed_status = (($current_completed_status+$add_completed_status)*100/$total);
        if ($completed_status >= 0 && $completed_status <= 100) {
            $pccs->setCompletedStatus($completed_status);
            $pccs->save();
        }
        
        if($parent_component_id != null) {
            $this->add($add_completed_status, $profile_id, $parent_component_id);            
        }
        
        if($paparent_component_id != null) {
            $this->add($add_completed_status, $profile_id, $paparent_component_id);            
        }
        
        if($papaparent_component_id != null) {
            $this->add($add_completed_status, $profile_id, $papaparent_component_id);            
        }
    }

    private function initCache($profile_id){
        $pccs = ProfileComponentCompletedStatus::getRepository()->createQuery("pccs")
                ->where("pccs.profile_id = ?", $profile_id);
                //->andWhere("pccs.component_id = ?", $component_id)
                //->fetchOne();
                //->limit($this->_completed_status_cache)
                

        foreach ($pccs->execute() as $one_pccs) {
            $this->_completed_status[$profile_id][$one_pccs->getComponentId()] = $one_pccs->getCompletedStatus();
        }
    }

    public function getCompletedStatus($profile_id, $component_id) {
        return 1;

        if(isset($this->_completed_status[$profile_id][$component_id])){
            return $this->_completed_status[$profile_id][$component_id];
        }

        if(!isset($this->_completed_status[$profile_id])){
            $this->_completed_status = array();
            $this->_completed_status[$profile_id] = array();
            $this->initCache($profile_id);
        }

        if(isset($this->_completed_status[$profile_id][$component_id])){
            return $this->_completed_status[$profile_id][$component_id];
        }else{
            return 0;
        }
    }

}
