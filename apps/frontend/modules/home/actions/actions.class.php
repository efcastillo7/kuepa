<?php

/**
 * chapter actions.
 *
 * @package    kuepa
 * @subpackage chapter
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {        
                
    	//check account status
    	$this->checkAccountStatus();

        //get user
        $user = $this->getUser();

        $this->profile = $this->getProfile();
        
        //get courses for that user
        $this->courses = ComponentService::getInstance()->getCoursesForUser( $this->getProfile() );

        //get courses ids
        $components_ids = array();
        foreach( $this->courses as $component )
        {
            $components_ids[] = $component->getId();
        }

        //set completed status for courses
        // $values = ProfileComponentCompletedStatusService::getInstance()->getArrayCompletedStatus($components_ids, $this->profile->getId());
        // $user->setCompletedStatus($components_ids, $values);

        // cache courses
        $user->setEnabledCourses($components_ids);
    }
}
