<?php

/**
 * Lesson
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Lesson extends BaseLesson {

    const TYPE = 'Lesson';
    private $_actual_resource_position = null;
    private $_resource_list_id = array();

    private function initResources(){
        $resources = $this->getResources();
        $this->_resource_list_id = array();
        foreach ($resources as $id => $obj) {
            $this->_resource_list_id[] = $obj->getId();
        }
    }

    public function setActualResource($resource_id){
        $this->_actual_resource = $resource_id;

        //get resources as list id
        $this->initResources();

        //update position
        if (!($this->_actual_resource_position = array_search($resource_id, $this->_resource_list_id))){
            $this->_actual_resource_position = 0;
        }

        return;
    }

    public function getActualResourceId(){
        if($this->_actual_resource_position == null){
            $this->initResources();
            $this->_actual_resource_position = 0;
        }
        return $this->_resource_list_id[$this->_actual_resource_position];
    }

    public function getPreviousResourceId(){
        if($this->_actual_resource_position > 0){
            return $this->_resource_list_id[$this->_actual_resource_position-1];
        }

        return null;
    }

    public function getNextResourceId(){
        if($this->_actual_resource_position < (count($this->_resource_list_id)-1)){
            return $this->_resource_list_id[$this->_actual_resource_position+1];
        }

        return null;
    }

    public function atLastResource(){
        return $this->_actual_resource_position == (count($this->_resource_list_id)-1);
    }

    public function atFirstResource(){
        return $this->_actual_resource_position == 0;
    }

    /**
     * 
     * @return LessonTable
     */
    public static function getRepository() {
        return Doctrine_Core::getTable('Lesson');
    }

    public function getResources() {
        return LessonService::getInstance()->getResourcesList($this->getId());
    }

    public function getLastResourceViewed($profile_id){
        return LogService::getInstance()->getLastResourceIdViewed($profile_id, $this);
    }

    public function getTotalTime($profile_id){
        return LogService::getInstance()->getTotalTime($profile_id, $this);
    }

}
