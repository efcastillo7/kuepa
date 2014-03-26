<?php

class myUser extends sfGuardSecurityUser {
    const SFGUARD_USER_ATTR = 'sfGuarUser';
    const PROFILE_ATTR = 'profile';
    const COMPONENT_COMPLETED_STATUS  = 'CacheComponentCompleteStatus';
    const USER_COURSES_ENABLED  = 'UserCoursesEnabled';
    const LAYOUT_STYLE  = 'CollegeLayoutStyle';
    const CULTURE_LANG = 'UserCultureLang';
    const CULTURE_TIMEZONE = 'UserCultureTimezone';
    
    public function isValidAccount() {
        //check if account is enabled - TODO: Add field
        //check if account date is valid
        $date = $this->getProfile()->getValidUntil();
        if ($date) {
            $valid_until = strtotime($date);
            $diff = $valid_until - time();

            return $diff > 0;
        }

        return true;
    }
    
    public function signIn($user, $remember = false, $con = null) {
        //entra cuando hay login succesfull
        //setear cultura de usuario, zona horaria, etc.
                
        //log in        
        parent::signIn($user, $remember, $con);

        $this->setUser($user);
        $this->setCourses($this);
        $this->setStyle($user);
        $this->setI18N($user);
    }
    
    public function signOut() {
        $this->clearCurrentUser();
        parent::signOut();
    }
    
    protected function setUser($user)
    {
        $profile = $user->getProfile();
        $this->setAttribute(self::PROFILE_ATTR, $user->getProfile());
        
        $user->setProfile( $profile );
        $this->setAttribute(self::SFGUARD_USER_ATTR, $user);
    }

    protected function setCourses($user){
        $courses = ComponentService::getInstance()->getCoursesForUser( $user->getProfile() );

        //get ids
        $components_ids = $courses->getPrimaryKeys();

        //set completed status for courses
        $values = ProfileComponentCompletedStatusService::getInstance()->getArrayCompletedStatus($components_ids, $user->getProfile()->getId());
        $user->setCompletedStatus($components_ids, $values);

        // cache courses
        $user->setEnabledCourses($components_ids);

        // add credentials for user
        foreach ($components_ids as $course_id) {
            $this->addCredential("course_" . $course_id);
        }
    }

    protected function setI18N($user){
        $profile = $user->getProfile();

        if($profile->getCulture()){
            $this->setAttribute(self::CULTURE_LANG, $profile->getCulture());
            $this->setCulture($profile->getCulture());
        }

        if($profile->getTimezone()){
            $this->setAttribute(self::CULTURE_TIMEZONE, $profile->getTimezone());
        }
    }

    protected function setStyle($user){
        $style = "";

        $colleges = $user->getProfile()->getColleges();

        if($colleges->count()){
            $style = $colleges->getFirst()->getStyle();
        }

        $this->setAttribute(self::LAYOUT_STYLE, $style);
    }

    public function getTimezone(){
        return $this->getAttribute(self::CULTURE_TIMEZONE);
    }

    public function getStyle(){
        return sfContext::getInstance()->getUser()->getAttribute(self::LAYOUT_STYLE);
    }
    
    public function getGuardUser()
    {
        return sfContext::getInstance()->getUser()->getAttribute(self::SFGUARD_USER_ATTR);
    }

    public function getProfile()
    {
        return sfContext::getInstance()->getUser()->getAttribute(self::PROFILE_ATTR);
    }
    
    protected function clearCurrentUser()
    {
        $this->setAttribute(self::SFGUARD_USER_ATTR, null);
        $this->setAttribute(self::PROFILE_ATTR, null);
        sfContext::getInstance()->getUser()->setAttribute(self::COMPONENT_COMPLETED_STATUS, null);
        sfContext::getInstance()->getUser()->setAttribute(self::USER_COURSES_ENABLED, null);
        sfContext::getInstance()->getUser()->setAttribute(self::LAYOUT_STYLE, null);
    }


    /* for cache */
    public function getEnabledCourses(){
        return sfContext::getInstance()->getUser()->getAttribute(self::USER_COURSES_ENABLED);
    }

    public function setEnabledCourses($course_id){
        $_courses = sfContext::getInstance()->getUser()->getAttribute(self::USER_COURSES_ENABLED, array());

        if(!is_array($course_id)){
            $course_id = array($course_id);
        }

        $_courses = array_unique (array_merge($_courses, $course_id));

        return sfContext::getInstance()->getUser()->setAttribute(self::USER_COURSES_ENABLED, $_courses);
    }


    public function setCompletedStatus($component_id, $value = 0){
        $_completed_status = $this->getAttribute(self::COMPONENT_COMPLETED_STATUS,array());

        if(is_array($component_id) && is_array($value)){
            foreach($component_id as $c_id){
                $_completed_status[$c_id] = isset($value[$c_id]) ? $value[$c_id] : 0;
            }
        }else{
            $_completed_status[$component_id] = $value;
        }

        $this->setAttribute(self::COMPONENT_COMPLETED_STATUS, $_completed_status);

        return $value;
    }

    public function getCompletedStatus($component_id = null){
        $_completed_status = $this->getAttribute(self::COMPONENT_COMPLETED_STATUS);

        if($component_id == null){
            return $_completed_status;
        }

        if(isset($_completed_status[$component_id])){
            return $_completed_status[$component_id];
        }

        //get from db
        $pccs = ProfileComponentCompletedStatusService::getInstance()->getCompletedStatus($this->getProfile()->getId(), $component_id);
        // $pccs = 0;

        return $this->setCompletedStatus($component_id, $pccs);
    }

}
