<?php

class CalendarService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new CalendarService;
        }
        
        return self::$instance;
    }
    
    public function createEvent($profile_id, $resource_id, $title, $description, $start, $end ) {

    }
    
    public function deleteEvent($calendar_event_id){

    }
    
    public function getUserEvents($profile_id) {
        $events =  CalendarEvent::getRepository()->findByProfileId($profile_id);

        return $events;
    }
}
