<?php

/**
 * export actions.
 *
 * @package    kuepa
 * @subpackage export
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class exportActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeCourse(sfWebRequest $request){
  	$id = $request->getParameter("id");

  	$course = CourseService::getInstance()->getCourseAndChaptersAndLessonsAndRresourcesArray($id);

    //compress
  	// echo var_dump($course); die();
  	$this->course = $course;

  	$obj = serialize($course);
	$response = $this->getResponse();

	$response->setContentType('text/csv');
	$file_name = $course['name'];
	$response->setHttpHeader('Content-Disposition', 'attachment; filename="' . $file_name . '.kpa"');
	$response->setContent($obj);

	return sfView::NONE;
  }
}
