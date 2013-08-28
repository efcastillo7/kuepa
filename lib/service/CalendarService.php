<?php

class CalendarService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new CalendarService;
        }
        
        return self::$instance;
    }
    
    public function createEvent($profile_id, $resource_id = null, $title, $description, $start, $end ) {
        $event = new CalendarEvent;
        $event->setProfileId($profile_id);
        $event->setResourceId($resource_id);
        $event->setTitle($title);
        $event->setDescription($description);
        $event->setStart($start);
        $event->setEnd($end);

        $event->save();

        return $event;
    }
    
    public function deleteEvent($calendar_event_id){

    }
    
    public function getUserEvents($profile_id) {
        $events =  CalendarEvent::getRepository()->findByProfileId($profile_id);

        return $events;
    }

    public function getUserCoursesEvents($profile_id) {
        $courses = ComponentService::getInstance()->getCoursesForUser($profile_id);

        $events = array();
        foreach ($courses as $course) {
            $events_course =  CalendarEvent::getRepository()->findByComponentId($course->id);
            array_push($events, $events_course);
        }

        return $events;
    }
}
