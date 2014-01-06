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

    $count_weekends = false;

    $profile_id = $this->getProfile()->getId();

    //graph
    $from_date = strtotime(LogService::getInstance()->getFirstAccess($profile_id, $course_id)) - 24*3600;
    $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $course_id);
    
    $days_remaining = stdDates::day_diff($from_date,$to_date);
    $working_days = stdDates::weekday_diff($from_date,$to_date);
    $days_from_started = stdDates::day_diff($from_date,time());

    $hs_course = $this->course->getDuration() / 3600;

    $hs_remaining = StatsService::getInstance()->getRemainingTime($profile_id, $course_id) / 3600 ;
    $hs_per_day = $hs_course / ($count_weekends ? $working_days : $days_remaining);

    $hs_per_week_dedicated = ($hs_course - $hs_remaining) / $days_from_started;

    $ndays = array('estimated' => array('x' => array(), 'y' => array()), 'real' => array('x' => array(), 'y' => array()));
    $days = -1;
    $last = round($hs_course);

    $today = time();

    for($i=0; $i<$days_remaining+1;$i++){ //add today
      $date = strtotime("+$i days", $from_date);
      $date_tomorrow = strtotime("+" . $i+1 . " days", $from_date);
      $days = $i;
      
      //check if weekday
      if($count_weekends){
        $weekday = date('w', $date);

        if($weekday > 0 &&  $weekday < 6){
          $days++;
        }
      }

      $ndays['estimated']['x'][] = round($hs_course - $days*$hs_per_day);
      $ndays['estimated']['y'][] = date('d/m', $date);

      if($date < $today){
        $hs_dedicated = round(LogService::getInstance()->getTotalTime($profile_id, $this->course, $date, $date_tomorrow)/3600);
        $ndays['real']['x'][] = $last - $hs_dedicated;
      }else{
        $hs_dedicated = $hs_per_week_dedicated;
      }

      $ndays['proyect']['x'][] = round($last - $hs_dedicated);
      $last -= $hs_dedicated;

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
