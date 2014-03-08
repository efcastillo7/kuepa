<?php
 
class statsComponents extends sfComponents
{
  public function executeBurndownChartDays()
  {
    $course_id = $this->course_id;
    $course = Course::getRepository()->getById($course_id);
    $count_weekends = false;

    $profile_id = $this->getUser()->getProfile()->getId();

    $this->seted_deadline = false;

    $first_access = LogService::getInstance()->getFirstAccess($profile_id, $course_id);
    
    if($first_access != null){
      $this->seted_deadline = true;

      //graph
      $from_date = strtotime($first_access);
      $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $course_id);
      
      $days_remaining = stdDates::day_diff($from_date,$to_date);
      $working_days = stdDates::weekday_diff($from_date,$to_date);
      $days_from_started = stdDates::day_diff($from_date,time());

      $hs_course = $course->getDuration() / 3600;

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
          $hs_dedicated = round(LogService::getInstance()->getTotalTime($profile_id, $course, $date, $date_tomorrow)/3600);
          $ndays['real']['x'][] = $last - $hs_dedicated;
        }else{
          $hs_dedicated = $hs_per_week_dedicated;
        }

        $ndays['proyect']['x'][] = round($last - $hs_dedicated);
        $last -= $hs_dedicated;

      }

      $this->days = $ndays;
    }
  }

  public function executeBurndownChartWeeks()
  {
    $course_id = $this->course_id;
    $course = Course::getRepository()->getById($course_id);
    $count_weekends = false;

    $profile_id = $this->getUser()->getProfile()->getId();

    $this->seted_deadline = false;

    $first_access = LogService::getInstance()->getFirstAccess($profile_id, $course_id);
    
    if($first_access != null){
      $this->seted_deadline = true;

      //graph
      $from_date = strtotime($first_access) - 24*3600;
      $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $course_id);
      
      $weeks_remaining = stdDates::day_diff($from_date,$to_date) / 7;
      $weeks_from_started = stdDates::day_diff($from_date,time()) / 7;

      $hs_course = $course->getDuration() / 3600;

      $hs_remaining = StatsService::getInstance()->getRemainingTime($profile_id, $course_id) / 3600 ;
      $hs_per_week = $hs_course / $weeks_remaining;

      $hs_per_week_dedicated = ($hs_course - $hs_remaining) / $weeks_from_started;

      $ndays = array('estimated' => array('x' => array(), 'y' => array()), 'real' => array('x' => array(), 'y' => array()));
      $days = -1;
      $last = round($hs_course);

      $today = time();

      $to_date = strtotime($to_date);

      for($i=0; $i<$weeks_remaining + 1;$i++){ //add today
        $date = strtotime("+$i weeks", $from_date);
        $date_tomorrow = MIN(strtotime("+" . $i+1 . " weeks", $from_date), $to_date);
        
        $ndays['estimated']['x'][] = MAX(round($hs_course - $i*$hs_per_week,1),0);
        $ndays['estimated']['y'][] = date('d/m', $date) . " a " . date('d/m', $date_tomorrow);

        if($date < $today){
          $hs_dedicated = round(LogService::getInstance()->getTotalTime($profile_id, $course, $date, $date_tomorrow)/3600);
          $ndays['real']['x'][] = $last - $hs_dedicated;
        }

        $last -= $hs_dedicated;

      }

      $this->days = $ndays;
    }
  }
}