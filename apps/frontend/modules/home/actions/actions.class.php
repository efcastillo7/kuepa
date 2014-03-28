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

    public function preExecute()
  {
    parent::preExecute();
    
    $this->setLayout("layout_v2");
  }

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
        $this->enabled_courses = CourseService::getInstance()->getCourses($user->getEnabledCourses());
        $this->display_courses = CourseService::getInstance()->getCourses($user->getDisplayCourses());
    }
}
