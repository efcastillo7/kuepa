<?php

class CalendarService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new CalendarService;
        }

        return self::$instance;
    }

    public function createEvent($profile_id, $component_id = null, $title, $description, $start, $end) {
        $event = new CalendarEvent;
        $event->setProfileId($profile_id);
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

    public function getUserEvents($profile_id, $start_date = null, $end_date = null) {
        $q = CalendarEvent::getRepository()->createQuery('ce')
                ->where('ce.profile_id = ?', $profile_id);

        if ($start_date)
            $q->andWhere('ce.start >= ?', $start_date);
        if ($end_date)
            $q->andWhere('ce.end <= ?', $end_date);

        return $q->execute();
    }

    public function getUserCoursesEvents($profile, $start_date = null, $end_date = null) {
        $courses = ComponentService::getInstance()->getCoursesForUser($profile);

        $events = array();
        foreach ($courses as $course) {
            $q = CalendarEvent::getRepository()->createQuery('ce')
                    ->where('ce.component_id = ?', $course->id);

            if ($start_date)
                $q->andWhere('ce.start >= ?', $start_date);
            if ($end_date)
                $q->andWhere('ce.end <= ?', $end_date);

            $events_course = $q->execute();

            array_push($events, $events_course);
        }

        return $events;
    }

    // los eventos de un usuario y un curso específico
    public function getEventsForUserInCourse($profile_id, $course_id, $start_date = null, $end_date = null) {
        $q = CalendarEvent::getRepository()->createQuery('ce')
                ->where('ce.profile_id = ?', $profile_id)
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
