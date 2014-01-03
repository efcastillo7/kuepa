<?php

/**
 * stats actions.
 *
 * @package    kuepa
 * @subpackage stats
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statsActions extends kuepaActions
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

    $profile_id = $this->getProfile()->getId();

    //graph
    $from_date = LogService::getInstance()->getFirstAccess($profile_id, $course_id);
    $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $course_id);
    
    $days_remaining = stdDates::day_diff($from_date,$to_date);
    $working_days = stdDates::weekday_diff($from_date,$to_date);

    $hs_course = $this->course->getDuration() / 3600;


    $hs_remaining = StatsService::getInstance()->getRemainingTime($profile_id, $course_id) / 3600 ;
    $hs_per_day = $hs_course / $working_days;

    $ndays = array('estimated' => array('x' => array(), 'y' => array()), 'real' => array('x' => array(), 'y' => array()));
    $days = -1;
    $last = $hs_remaining;

    for($i=0; $i<$days_remaining+1;$i++){
      $date = strtotime("+$i days", $from_date);
      
      //check if weekday
      $weekday = date('w', $date);

      if($weekday > 0 &&  $weekday < 6){
        $days++;
      }
      // $days = $i;

      $ndays['estimated']['x'][] = round($hs_course - $days*$hs_per_day);
      $ndays['estimated']['y'][] = date('d/m', $date);

      if($days > 10){
        $rnd = rand(0,5);
        $ndays['real']['x'][] = round($last - $rnd);  
        $last-= $rnd;
      }else{
        $ndays['real']['x'][] = round($hs_course);
      }
      

      
    }

    $this->days = $ndays;


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

  public function executeTest(sfWebRequest $request){
    $component_id = $request->getParameter('id');
    $stats = StatsService::getInstance();

    $profile = $this->getProfile();
    $profile_id = $profile->getId();
    // $component_id = 692;

    $this->li = $stats->getLearningIndex($profile_id, $component_id);
    $this->efi = $stats->getEfficiencyIndex($profile_id, $component_id);
    $this->efo = $stats->getEffortIndex($profile_id, $component_id);
    $this->v = $stats->getVelocityIndex($profile_id, $component_id);
    $this->sk = $stats->getSkillIndex($profile_id, $component_id);
    $this->c = $stats->getCompletitudIndex($profile_id, $component_id);
    $this->p = $stats->getPersistenceIndex($profile_id, $component_id);


  }
}
