<?php

/**
 * Profile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Profile extends BaseProfile
{
    private $_total_time, $_first_access, $_last_access;

	/**
     * 
     * @return ProfileTable
     */
    public static function getRepository() {
        return Doctrine_Core::getTable('Profile');
    }

    public function getFirstAccess(){
        if(!$this->_first_access){
            $this->_first_access = LogService::getInstance()->getFirstAccess($this->getId());;
        }

        return $this->_first_access;
    }

    public function getLastAccess(){
        if(!$this->_last_access){
            $this->_last_access = LogService::getInstance()->getLastAccess($this->getId());
        }

        return $this->_last_access;
    }

    public function getTotalTime($component = null){
        if(!$this->_total_time){
            $this->_total_time = LogService::getInstance()->getTotalTime($this->getId(), $component);
        }

        return $this->_total_time;
    }

    public function getWeekTime($component = null){
        $weeks = stdDates::weekday_diff($this->getFirstAccess(),$this->getLastAccess());
        if($weeks > 0){
            return $this->getTotalTime($component) / $weeks;
        }

        return 0;        
    }

    public function getAvatar(){
        if($this->_get('avatar') != ""){
            return $this->_get('avatar');
        }

        return "default.png";
    }

    public function getAvatarPath(){
        return "/uploads/avatars/";
    }

    public function getTotalRecourseViewed(){
    	return LogService::getInstance()->getTotalRecourseViewed($this->getId());
    }

    public function getFullName(){
        return $this->getFirstName() . " " . $this->getLastName();
    }

    public function getComponentStatus($component_id){
        return ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($this->getId(), $component_id);
    }

    public function getFriends(){
        return ProfileService::getInstance()->getFriends($this);
    }

    public function getRemainingTime($component_id){
        return ProfileService::getInstance()->getRemainingTime($this->getId(), $component_id);
    }
}
