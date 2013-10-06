<?php

/**
 * stats actions.
 *
 * @package    kuepa
 * @subpackage stats
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }

  public function executeCourse(sfWebRequest $request)
  {
    $course_id = $request->getParameter("course_id");

    $this->course = CourseService::getInstance()->find($course_id);

    $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }
}
