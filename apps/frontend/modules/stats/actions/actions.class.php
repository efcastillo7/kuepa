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
   $this->courses = ComponentService::getInstance()->getCoursesForUser($this->getUser()->getGuardUser()->getProfile()->getId()); 
  }

  public function executeCourse(sfWebRequest $request)
  {
    $course_id = $request->getParameter("id");

    $this->course = Course::getRepository()->find($course_id);
    $this->chapters = $this->course->getChapters();
    // $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }

  public function executeChapter(sfWebRequest $request)
  {
    $course_id = $request->getParameter("course");
    $chapter_id = $request->getParameter("chapter");

    $this->course = Course::getRepository()->find($course_id);
    $this->chapter = Chapter::getRepository()->find($chapter_id);
    $this->lessons = $this->chapter->getLessons();
    // $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }

  public function executeLesson(sfWebRequest $request)
  {
    $course_id = $request->getParameter("course");
    $chapter_id = $request->getParameter("chapter");
    $lesson_id = $request->getParameter("lesson");

    $this->course = Course::getRepository()->find($course_id);
    $this->chapter = Chapter::getRepository()->find($chapter_id);
    $this->lesson = Lesson::getRepository()->find($lesson_id);
    $this->resources = $this->lesson->getResources();
    // $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }

  public function executeTimeline(sfWebRequest $request){
    $from = $request->getParameter("from");
    $to = $request->getParameter("to");
    $count = $request->getParameter("count", 10);
    // $to = $from = null; 

    $this->logs = array();
    
    if ($request->isXmlHttpRequest()) {
        $this->logs = LogService::getInstance()->getLastViewedResources($this->getUser()->getProfile()->getId(), $from, $to, $count);

        $response = Array(
            'status' => 'success',
            'template' => $this->getPartial('timeline_points'),
            'last_date' => strtotime($this->logs->getLast()->created_at)
        );

        return $this->renderText(json_encode($response));
    }
  }

  public function executeClass(sfWebRequest $request){
    $course_id = $request->getParameter("course");

    $this->course = Course::getRepository()->find($course_id);
    $this->students = CourseService::getInstance()->getStudentsList($course_id);

  }
}
