<?php

class CalendarService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new CalendarService;
        }

        return self::$instance;
    }

    public function createEvent( $component_id = null, $title, $description, $start, $end) {
        $event = new CalendarEvent;
        $event->setComponentId($component_id);
        $event->setTitle($title);
        $event->setDescription($description);
        $event->setStart($start);
        $event->setEnd($end);

        $event->save();

        return $event;
    }

    public function deleteEvent($calendar_event_id) {
        $q = CalendarEvent::getRepository()->createQuery()->delete()
                ->where("id = ?", $calendar_event_id);

        return $q->execute();
    }

    public function getUserEvents( $start_date = null, $end_date = null) {
        
        $q = CalendarEvent::getRepository()->createQuery('ce');

        if ($start_date)
            $q->andWhere('ce.start >= ?', $start_date);
        if ($end_date)
            $q->andWhere('ce.end <= ?', $end_date);

        return $q->execute();
    }

    // los eventos de un usuario y un curso específico
    public function getEventsForUserInCourse( $course_id, $start_date = null, $end_date = null) {
        $q = CalendarEvent::getRepository()->createQuery('ce')
                ->andWhere('ce.component_id = ?', $course_id)
                ->orderBy('ce.created_at desc');

        if ($start_date)
            $q->andWhere('ce.start >= ?', $start_date);
        if ($end_date)
            $q->andWhere('ce.end <= ?', $end_date);

        return $q->execute();
    }

    public function editEvent($event_id, $values = array()) {
        $event = CalendarEvent::getRepository()->find($event_id);

        if ($event) {
            //editable fields
            $values_keys = array('title', 'description', 'start', 'end');

            foreach ($values_keys as $key) {
                //check if loaded
                if (isset($values[$key])) {
                    $event->set($key, $values[$key]);
                }
            }
            $event->save();
        }

        return $event;
    }

}
