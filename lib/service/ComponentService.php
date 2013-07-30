<?php

class ComponentService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new ComponentService;
        }
        
        return self::$instance;
    }
    
    public function getCoursesForUser($profile_id) {
        $courses = Course::getRepository()->getChaptersForUser($profile_id);
        
        return $courses;
    }
    
    public function getChaptersForCourse($profile_id) {
        $chapters = Chapter::getRepository()->getChaptersForUser($profile_id);
        
        return $chapters;
    }
    
    public function getLessonsForUser($profile_id) {
        $lessons = Lessons::getRepository()->getChaptersForUser($profile_id);
        
        return $lessons;
    }
    
    public function getResourcesForUser($profile_id) {
        $lessons = Resources::getRepository()->getChaptersForUser($profile_id);
        
        return $lessons;
    }
}
