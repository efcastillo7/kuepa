<?php

class myUser extends sfGuardSecurityUser {

    const SFGUARD_USER_ATTR = 'sfGuarUser';
    const PROFILE_ATTR = 'profile';
    const COMPONENT_COMPLETED_STATUS  = 'CacheComponentCompleteStatus';
    const USER_COURSES_ENABLED  = 'UserCoursesEnabled';
    const USER_COURSES  = 'UserCourses';
    const LAYOUT_STYLE  = 'CollegeLayoutStyle';
    const USER_COLLEGES = 'UserColleges';
    const CULTURE_LANG = 'UserCultureLang';
    const CULTURE_TIMEZONE = 'UserCultureTimezone';
    const LOGOUT_URL = 'LogoutURL';
    
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
                
               
        parent::signIn($user, $remember, $con);

        $this->setUser($user);
	   $this->setCourses($this);
    }
    
    public function signOut() {
        parent::signOut();
        $this->clearCurrentUser();
    }
    
    protected function setUser($user)
    {
        $profile = $user->getProfile();
        $this->setAttribute(self::PROFILE_ATTR, $user->getProfile());
        
        $user->setProfile( $profile );
        $this->setAttribute(self::SFGUARD_USER_ATTR, $user);
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
        return $this->setAttribute(self::SFGUARD_USER_ATTR, null);
        return $this->setAttribute(self::PROFILE_ATTR, null);
    }

    protected function setCourses($user){
        $courses = ComponentService::getInstance()->getCoursesForUser( $user->getProfile() );
        $enabled_courses = ComponentService::getInstance()->getEnabledCoursesForUser( $user->getProfile() );

        if($enabled_courses->count() == 0){
            $enabled_courses = $courses;
        }

        //cache all courses
        if(count($courses)){
            $user->setAllCourses($courses->getPrimaryKeys());
        }else{
            $user->setAllCourses(array());
        }

        if($enabled_courses && $enabled_courses->count()){
            //get ids
            $components_ids = $enabled_courses->getPrimaryKeys();

            //set completed status for courses
            $values = ProfileComponentCompletedStatusService::getInstance()->getArrayCompletedStatus($components_ids, $user->getProfile()->getId());
            $user->setCompletedStatus($components_ids, $values);

            // cache courses
            $user->setEnabledCourses($components_ids);

            // add credentials for user
            foreach ($components_ids as $course_id) {
                $this->addCredential("course_" . $course_id);
            }
        }else{
            $user->setEnabledCourses(array());            
        }
    }

    public function setAllCourses($course_id){
        $_courses = sfContext::getInstance()->getUser()->getAttribute(self::USER_COURSES, array());

        if(!is_array($course_id)){
            $course_id = array($course_id);
        }

        $_courses = array_unique(array_merge($_courses, $course_id));

        return sfContext::getInstance()->getUser()->setAttribute(self::USER_COURSES, $_courses);
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
    
    public function setEnabledCourses($course_id){
        $_courses = sfContext::getInstance()->getUser()->getAttribute(self::USER_COURSES_ENABLED, array());
    
        if(!is_array($course_id)){
            $course_id = array($course_id);
        }
    
        $_courses = array_unique (array_merge($_courses, $course_id));
    
        return sfContext::getInstance()->getUser()->setAttribute(self::USER_COURSES_ENABLED, $_courses);
    }
    

}
