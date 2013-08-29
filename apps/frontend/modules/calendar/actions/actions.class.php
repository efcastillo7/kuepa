<?php

/**
 * calendar actions.
 *
 * @package    kuepa
 * @subpackage calendar
 * @author     fiberbunny
 */
class calendarActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {  
    	
    }

    /**
     * Executes getEvents action
     *
     * @param sfRequest $request A request object
     */
    public function executeGetEvents(sfWebRequest $request){
    	$events = CalendarService::getInstance()->getUserEvents($this->getUser()->getGuardUser()->getProfile()->getId());

    	// Initializes a container array for all of the calendar events
		$jsonArray = array();
    	foreach ($events as $event) {
			$buildjson = array( 'id' => $event->id,
								'title' => $event->title, 
								'description' => $event->description,
								'start' => $event->start, 
								'end' => $event->end, 
								'allday' => false,
								'backgroundColor' => '#GGFDEE');
			array_push($jsonArray, $buildjson);
    	}

   		return $this->renderText(json_encode($jsonArray));
    }

    /**
     * Executes getCoursesEvents action
     *
     * @param sfRequest $request A request object
     */
    public function executeGetCoursesEvents(sfWebRequest $request){

    	$events = CalendarService::getInstance()->getUserCoursesEvents($this->getUser()->getGuardUser()->getProfile()->getId());

    	// Initializes a container array for all of the calendar events
		$jsonArray = array();
    	foreach ($events as $event) {
			$buildjson = array( 'id' => $event->id,
								'title' => $event->title, 
								'description' => $event->description,
								'start' => $event->start, 
								'end' => $event->end, 
								'allday' => false,
								'backgroundColor' => '#33GG66');
			array_push($jsonArray, $buildjson);
    	}

   		return $this->renderText(json_encode($jsonArray));

    }

}