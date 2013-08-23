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
    	$events = CalendarService::getInstance()->getEvents($this->getUser()->getGuardUser()->getProfile()->getId());

    	// Initializes a container array for all of the calendar events
		$jsonArray = array();
    	foreach ($events as $event) {
			$buildjson = array('id' => $event->id,'title' => $event->title, 'start' => $event->start, 'end' => $event->end, 'allday' => false);
			array_push($jsonArray, $buildjson);
    	}

    	echo json_encode($jsonArray);
    }


}