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

    public function editEvent($event_id, $profile_id, $resource_id = null, $title, $description, $start, $end){
        $event = CalendarEvent::getRepository()->find($event_id);
        
        if( $event && $event->getProfileId() == $profile_id) {
            $event->setResourceId($resource_id);
            $event->setTitle($title);
            $event->setDescription($description);
            $event->setStart($start);
            $event->setEnd($end);
            $event->save();
        }
        
        return $event;
    }
    
    public function deleteEvent($event_id, $profile_id){
        $event = CalendarEvent::getRepository()->find($event_id);

        if ($event_id && $event->getProfileId() == $profile_id ) {
            $event_id->delete();
        }
        return;
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

    public static function getUserEventsByDateRange($profile_id, $resource_id = null, $initial_date, $final_date){
        $events = CalendarEvent::getRepository()->getEventsForUserByDate($profile_id, $resource_id, $initial_date, $final_date);

        print_r($events->toArray());

        return $events;
    }
}
