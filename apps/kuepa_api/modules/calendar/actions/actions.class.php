<?php

/**
 * calendar actions.
 *
 * @package    kuepa
 * @subpackage calendar
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class calendarActions extends sfActions {

    public function executeCreate(sfWebRequest $request) {
        $profile = $this->getUser()->getProfile();

        $component_id = $request->getPostParameter("component_id");
        $title = $request->getPostParameter("title");
        $description = $request->getPostParameter("description");
        $start = $request->getPostParameter("start");
        $end = $request->getPostParameter("end");

        $event = CalendarService::getInstance()->createEvent($profile, $component_id, $title, $description, $start, $end);

        $response = array(
            'success' => $event ? true : false
        );

        return $this->renderText(json_encode($response));
    }

    public function executeDelete(sfWebRequest $request) {
        $calendar_event_id = $request->getPostParameter("id");
        CalendarService::getInstance()->deleteEvent($calendar_event_id);

        $response = array(
            'success' => true
        );

        return $this->renderText(json_encode($response));
    }

    public function executeGetevents(sfWebRequest $request) {
        $profile = $request->getPostParameter("profile");
        $course_id = $request->getPostParameter("course_id");
        $start = $request->getPostParameter("start");
        $end = $request->getPostParameter("end");
        $by_course = $request->getPostParameter("by_course");

        if ($profile && $course_id) {
            $events = CalendarService::getInstance()->getEventsForUserInCourse($profile, $course_id, $start, $end);
        }
        elseif ($profile && $by_course) {
            $profile = Profile::getRepository()->find($profile);            
            $events = CalendarService::getInstance()->getUserCoursesEvents($profile, $start, $end);
        }
        elseif ($profile) {
            $events = CalendarService::getInstance()->getUserEvents($profile, $start, $end);
        }

        $response = array();

        foreach ($events as $event) {
            $response[] = array(
                'id' => $event->getId(),
                'profile_id' => $event->getProfileId(),
                'component_id' => $event->getComponentId(),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'start' => strtotime($event->getStart()),
                'end' => strtotime($event->getEnd())
            );
        }

        return $this->renderText(json_encode($response));
    }

}
