<?php

/**
 * log actions.
 *
 * @package    kuepa
 * @subpackage log
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class logActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeResource(sfWebRequest $request)
  {
    $resource_id = $request->getParameter("resource_id");
    $course_id = $request->getParameter("course_id");
    $chapter_id = $request->getParameter("chapter_id");
    $lesson_id = $request->getParameter("lesson_id");

    $time = LogService::getInstance()->viewResource($this->getUser()->getProfile()->getId(), 
      Resource::TYPE, $course_id, $chapter_id, $lesson_id, $resource_id);

    $time_lapse = strtotime($time->getUpdatedAt()) - strtotime($time->getCreatedAt());

    $response = array('status' => 'success', 'time_lapse' => $time_lapse);

    return $this->renderText(json_encode($response));
  }
}
