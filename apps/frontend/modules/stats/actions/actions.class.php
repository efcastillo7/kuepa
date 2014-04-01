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
  public function executeIndex(sfWebRequest $request)
  {
   $this->courses = CourseService::getInstance()->getCoursesAndChapters($this->getUser()->getEnabledCourses());
   $this->times = ProfileComponentCompletedStatusService::getInstance()->getArrayCompletedTimes($this->getUser()->getEnabledCourses(), $this->getUser()->getProfile()->getId());
  }

  public function executeCourse(sfWebRequest $request)
  {
    $course_id = $request->getParameter("id");

    $this->course = Course::getRepository()->getById($course_id);
    $this->chapters = $this->course->getChapters();

    $profile = $this->getProfile();
    
    $this->viewed_times = ProfileComponentCompletedStatusService::getInstance()->getArrayCompletedTimes($this->chapters->getPrimaryKeys(), $profile->getId());

    $first_access = LogService::getInstance()->getFirstAccess($profile->getId(), $course_id);
    $to_date = ComponentService::getInstance()->getDeadlineForUser($profile->getId(), $course_id);

    $this->has_stats = $first_access != null && $to_date != null;
    $this->seted_deadline = $to_date != null;
    $now = time();
    $days_remaining = stdDates::day_diff($now, $to_date);
    
    if($first_access != null){
      //graph
      $from_date = strtotime($first_access) - 24*3600;

      $days = stdDates::day_diff($from_date, $now);

      $this->stats = array(
        'hs_dedicated' => round(LogService::getInstance()->getTotalTime($profile->getId(), $this->course, $from_date, $now)/3600),
        'hs_remaining' => round(StatsService::getInstance()->getRemainingTime($profile->getId(), $course_id) / 3600),
        'days_lapse' => $days,
        'weeks_lapse' => floor($days/7),
        'days_remaining' => $days_remaining,
        'weeks_remaining' => $days_remaining/7,
        'course_duration' => $this->course->getDuration() / 3600
      );
    }
    

    // $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }

  public function executeChapter(sfWebRequest $request)
  {
    $course_id = $request->getParameter("course");
    $chapter_id = $request->getParameter("chapter");

    $this->course = Course::getRepository()->getById($course_id);
    $this->chapter = Chapter::getRepository()->getById($chapter_id);
    $this->lessons = $this->chapter->getLessons();
    // $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }

  public function executeLesson(sfWebRequest $request)
  {
    $course_id = $request->getParameter("course");
    $chapter_id = $request->getParameter("chapter");
    $lesson_id = $request->getParameter("lesson");

    $this->course = Course::getRepository()->getById($course_id);
    $this->chapter = Chapter::getRepository()->getById($chapter_id);
    $this->lesson = Lesson::getRepository()->getById($lesson_id);
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

    $this->course = Course::getRepository()->getById($course_id);
    $this->students = CourseService::getInstance()->getStudentsList($course_id);
  }

  public function executeTest(sfWebRequest $request){
    $component_id = $request->getParameter('id');
    $stats = StatsService::getInstance();

    $profile = $this->getProfile();
    $profile_id = $profile->getId();
    
    //$profile_id = 101;
    $component_id = 46;

    $this->component = ComponentService::getInstance()->find($component_id);
    $this->profile_id = $profile_id;

    $this->sk = $stats->getSkillIndex($profile_id, $component_id);
    $this->v = $stats->getVelocityIndex($profile_id, $component_id);
    $this->efi = $stats->getEfficiencyIndex($this->v, $this->sk);
    $this->c = $stats->getCompletitudIndex($profile_id, $component_id);
    $this->p = $stats->getPersistenceIndex($profile_id, $component_id);
    $this->efo = $stats->getEffortIndex($this->c, $this->p);
    $this->li = $stats->getLearningIndex($this->efo, $this->efi);


  }

  public function executeTest2(sfWebRequest $request){
    /*
      $profile_id = 101;
      $component_id = 692;
      $this->component = ComponentService::getInstance()->find($component_id);
    */
    $component_id = ( $request->getParameter('course_id') ) ?  $request->getParameter('course_id') : 1791 ;
    $this->limit = ( $request->getParameter('limit') ) ?  $request->getParameter('limit') : 5 ;
    $this->offset = ( $request->getParameter('offset') ) ?  $request->getParameter('offset') : 0 ;
    $statsObj = StatsService::getInstance();
    ini_set('max_execution_time',180);
    $this -> courses = Course::getRepository()
                       ->createQuery('c')
                       ->orderBy("c.name")
                       ->execute();

    //$component_id = 50; // Lesson
    //$component_id = 47; // Unidad
    //$component_id = 1791; // course
    $this->component = ComponentService::getInstance()->find($component_id);

    $profiles = Profile::getRepository()->createQuery('p')
                // ->where('id = ?', 6)
                 ->limit($this->limit)
                 ->offset($this->offset)
                ->orderBy('id asc')
                ->execute();
    $stats = array();
/*    $first_access = LogService::getInstance()->getFirstAccess($profile_id, $course_id);
    $from_date = strtotime($first_access) - 24*3600;*/
 
    foreach ($profiles as $key => $profile) {
      $profile_id = $profile->getId();

      $s['profile'] = $profile;
      $s['v'] = $statsObj->getVelocityIndex($profile_id, $component_id);
      $s['sk'] =  $statsObj->getSkillIndex($profile_id, $component_id);
      $s['c'] = $statsObj->getCompletitudIndex($profile_id, $component_id);
      
      $s['efi'] =  $statsObj->getEfficiencyIndex($s['v'], $s['sk']);
       
      $invest_time = LogService::getInstance()->getTotalTime($profile_id, $this->component);
      $s['dc'] = $this->component->getDuration();
      $s['ti'] = $invest_time;

   

      $s['available_resources'] = ComponentService::getInstance()->getCountResources($component_id);
      $s['viewed_resources'] = LogService::getInstance()->getTotalRecourseViewed($profile_id, $component_id, true);

      $freq = 7;

      $s['p'] = $statsObj->getPersistenceIndex($profile_id, $component_id, time(), $freq);
      
      $s['efo'] = $statsObj->getEffortIndex($s['c'], $s['p']);
    
      $s['li'] = $statsObj->getLearningIndex($s['efo'], $s['efi']);
      
      $s['needed_time'] = $statsObj->getNeededTimePerPeriod($profile_id, $this->component, $freq);

      $from_ts = time() - ($freq * 24 * 60 * 60);
      $s['invest_time'] = $statsObj->getStudiedTimePerPeriod($profile_id, $this->component, $from_ts, time());

      array_push($stats, $s);
    }
    $this->stats = $stats;

  }

  public function executeTest3(sfWebRequest $request){
    $st = StatsService::getInstance();
    $di = $st->dist_norm_standard(1.33);
    echo $di;
    exit();
  }

}
