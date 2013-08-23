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
    	$this->events = CalendarService::getInstance()->getEvents($this->getUser()->getGuardUser()->getProfile()->getId());

    	foreach ($this->events as $event) {
    		# code...
    	}
    	/*
    	formato json
    	[

			{"title":"Varsity Cheerleading practice","start":"2011-10-13","allday":false},

			{"title":"Varsity Golf Practice","start":"2011-10-26","allday":false}

			]
    	*/
    	
    }


}