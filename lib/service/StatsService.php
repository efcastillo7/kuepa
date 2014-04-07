<?php

class StatsService {

    private static $instance = null;
    private $_approveBar = 70;
    private $_pond = 0.35;
    private $_invest_time = 0;
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new StatsService;
        }

        return self::$instance;
    }
    
    public function getVelocityIndex($profile_id, $component_id){
        //get component
        $component = Component::getRepository()->getById($component_id);

        //get invest time
        $this->_invest_time = LogService::getInstance()->getTotalTime($profile_id, $component);
        $v = 0;
        if( $this->_invest_time > 0 ){
            $v = $component->getDuration() / $this->_invest_time;
        }
        return $this->dist_norm_standard( M_PI /(2*log($v)) );
    }

    public function getCompletitudIndex($profile_id, $component_id){
        //get count component childs
        //$childs_total = ComponentService::getInstance()->getCountChilds($component_id);
        $childs_total = ComponentService::getInstance()->getCountResources($component_id);

        //get how many of that childs was seen
        //IMPORTANT! childs_viewed ALWAYS must be count of resources of that component
        // FE: if that component is a Chapter must return = SUM(count_resources(chapter.lesson))
        // TODO: make it recursive!
        $childs_viewed = LogService::getInstance()->getTotalRecourseViewed($profile_id, $component_id, true);
 
        //one could return the percentage of the ProfileComponentCompletedStatus
        // if resources were deleted so
        // the child viewed will be more than 100%
        if ( $childs_viewed > $childs_total){
            $percent = 1;
        }else{
            $percent  = $childs_viewed / $childs_total;
        }

        return $percent;
    }

    public function getSkillIndex($profile_id, $component_id){
        $note_avg = ComponentService::getInstance()->getNoteAvg($profile_id, $component_id);

        // $childs_viewed = LogService::getInstance()->getTotalRecourseViewed($profile_id, $component_id);

        // return 1 - ($note_avg  / $childs_viewed);

        return $note_avg;

        //TODO:
        //if component is a Chapter then skill is the avg of lesson notes weighted by #resources
        //if component is a Course then skill is the avg of chapter notes weighted by #resources
    }

    public function getPersistenceIndex($profile_id, $course_id, $start_ts = null, $freq = 7){
        /*
         * Borrada  Manera antigua de calcular
         */
        $course = Component::getRepository()->getById($course_id);
        $to_date = ( empty($start_ts) ) ? time() : $start_ts;
        $from_date = $to_date - ($freq * 24 * 60 * 60); // $freq 7 weekly, 30 monthly

        $estimated_hours_per_period = $this->getNeededTimePerPeriod($profile_id, $course, $freq);
        // DISTR.NORM.ESTAND(PI()/2*LN(HORASDEESTUDIOESTASEMANA/HORASESTUDIORECOMENDADASESTASEMANA)             
        if ( $estimated_hours_per_period > 0){
            $studied_hs_period = $this->getStudiedTimePerPeriod($profile_id, $course, $from_date, $to_date);
            $p_index = $this->dist_norm_standard( M_PI /(2*log($studied_hs_period / $estimated_hours_per_period)) );
        }else{
            $p_index = $this->dist_norm_standard(0);
        }

        return ($p_index);
    }

    /**
    * @freq = frequency in days
    */
    public function getNeededTimePerPeriod($profile_id, $course, $freq = 7){

        $hs_course = $course->getDuration() / 3600;
        $first_access = LogService::getInstance()->getFirstAccess($profile_id, $course->getId());

        $dead_line = ComponentService::getInstance()->getDeadlineForUser($profile_id, $course->getId());
        $estimated_time_freq = stdDates::day_diff($first_access, $dead_line)/$freq;
        
        if ( $estimated_time_freq > 0){
            $estimated_hours_per_period = $hs_course / $estimated_time_freq;
        }else{
            $estimated_hours_per_period = 0;
        }

        return($estimated_hours_per_period);
    } 

    public function getStudiedTimePerPeriod($profile_id, $course, $from_date, $to_date){
        $s_time = round(LogService::getInstance()->getTotalTime($profile_id, $course, $from_date, $to_date)/3600);       
        return($s_time);
    }

    public function getEfficiencyIndex($velocityIndex, $skillIndex){
        return $velocityIndex * $skillIndex;
    }

    public function getEffortIndex($completitudIndex, $persistenceIndex){
        return $completitudIndex * $persistenceIndex;
    }

    public function getLearningIndex($effortIndex, $efficiencyIndex){
        return $effortIndex * $this->_pond +
                $efficiencyIndex * (1-$this->_pond);
    }

    public function getRemainingTime($profile_id, $component_id){
        $component = Component::getRepository()->getById($component_id);

        $time_given = $component->getDuration();

        return $time_given - $this->_invest_time;
    }

    public function getAvgAdvancePerDay($profile_id, $component_id, $from_date = null, $to_date = null){
        $component = Component::getRepository()->getById($component_id);

        if($from_date == null){
            //first access
            $from_date = strtotime(LogService::getInstance()->getFirstAccess($profile_id, $course_id));
        }

        if($to_date == null){
            //now
            $to_date = time();
        }

        $time_dedicated = LogService::getInstance()->getTotalTime($profile_id, $component, $from_date, $to_date) / 3600;
        $days_between = stdDates::day_diff($from_date, $to_date);

        return $time_dedicated / $days_between;
    }

    public function getAvgAdvancePerWeek($profile_id, $component_id, $from_date = null, $to_date = null){
        //avg per day * 7 days
        return $this->getAdvancePerDay($profile_id, $component_id, $from_date, $to_date) * 7;
    }

    public function getRemainingPerWeek($profile_id, $component_id, $from_date = null, $to_date = null){

        $remaining = $this->getRemainingTime($profile_id, $component_id);

        if($to_date == null){
            $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $component_id);
            //pass to seconds
            $to_date = strtotime($to_date);
        }

        if($from_date == null){
            $from_date = time();
        }

        $weeks = (stdDates::day_diff($from_date,$to_date) + 1) / 7;

        return $remaining / $weeks;
    }

    public function getRemainingPerDay($profile_id, $component_id, $from_date = null, $to_date = null){

        $remaining = $this->getRemainingTime($profile_id, $component_id);

        if($to_date == null){
            $to_date = ComponentService::getInstance()->getDeadlineForUser($profile_id, $component_id);
            //pass to seconds
            $to_date = strtotime($to_date);
        }

        if($from_date == null){
            $from_date = time();
        }

        $days_remaining = stdDates::day_diff($from_date,$to_date);

        return $remaining / $days_remaining;
    }
    
    public function get_normal_dist_table(){
        // 0=  0.00
        // 0.004 = para Z = 0.01 ( posicion en el array = 1, z(0.01) * 100 = 1 )
        // 0.008 = para Z = 0.02 ( )
        $dnstable = array(0, 0.004, 0.008, 0.012,0.016,0.0199,0.0239,0.0279,0.0319,0.0359,
                0.0398,0.0438,0.0478,0.0517,0.0557,0.0596,0.0636,0.0675,0.0714,0.0753,
                0.0793,0.0832,0.0871,0.091,0.0948,0.0987,0.1026,0.1064,0.1103,0.1141,
                0.1179,0.1217,0.1255,0.1293,0.1331,0.1368,0.1406,0.1443,0.148,0.1517,
                0.1554,0.1591,0.1628,0.1664,0.17,0.1736,0.1772,0.1808,0.1844,0.1879,
                0.1915,0.195,0.1985,0.2019,0.2054,0.2088,0.2123,0.2157,0.219,0.2224,
                0.2257,0.2291,0.2324,0.2357,0.2389,0.2422,0.2454,0.2486,0.2517,0.2549,
                0.258,0.2611,0.2642,0.2673,0.2704,0.2734,0.2764,0.2794,0.2823,0.2852,
                0.2881,0.291,0.2939,0.2967,0.2995,0.3023,0.3051,0.3078,0.3106,0.3133,
                0.3159,0.3186,0.3212,0.3238,0.3264,0.3289,0.3315,0.334,0.3365,0.3389,
                0.3413,0.3438,0.3461,0.3485,0.3508,0.3531,0.3554,0.3577,0.3599,0.3621,
                0.3643,0.3665,0.3686,0.3708,0.3729,0.3749,0.377,0.379,0.381,0.383,
                0.3849,0.3869,0.3888,0.3907,0.3925,0.3944,0.3962,0.398,0.3997,0.4015,
                0.4032,0.4049,0.4066,0.4082,0.4099,0.4115,0.4131,0.4147,0.4162,0.4177,
                0.4192,0.4207,0.4222,0.4236,0.4251,0.4265,0.4279,0.4292,0.4306,0.4319,
                0.4332,0.4345,0.4357,0.437,0.4382,0.4394,0.4406,0.4418,0.4429,0.4441,
                0.4452,0.4463,0.4474,0.4484,0.4495,0.4505,0.4515,0.4525,0.4535,0.4545,
                0.4554,0.4564,0.4573,0.4582,0.4591,0.4599,0.4608,0.4616,0.4625,0.4633,
                0.4641,0.4649,0.4656,0.4664,0.4671,0.4678,0.4686,0.4693,0.4699,0.4706,
                0.4713,0.4719,0.4726,0.4732,0.4738,0.4744,0.475,0.4756,0.4761,0.4767,
                0.4772,0.4778,0.4783,0.4788,0.4793,0.4798,0.4803,0.4808,0.4812,0.4817,
                0.4821,0.4826,0.483,0.4834,0.4838,0.4842,0.4846,0.485,0.4854,0.4857,
                0.4861,0.4864,0.4868,0.4871,0.4875,0.4878,0.4881,0.4884,0.4887,0.489,
                0.4893,0.4896,0.4898,0.4901,0.4904,0.4906,0.4909,0.4911,0.4913,0.4916,
                0.4918,0.492,0.4922,0.4925,0.4927,0.4929,0.4931,0.4932,0.4934,0.4936,
                0.4938,0.494,0.4941,0.4943,0.4945,0.4946,0.4948,0.4949,0.4951,0.4952,
                0.4953,0.4955,0.4956,0.4957,0.4959,0.496,0.4961,0.4962,0.4963,0.4964,
                0.4965,0.4966,0.4967,0.4968,0.4969,0.497,0.4971,0.4972,0.4973,0.4974,
                0.4974,0.4975,0.4976,0.4977,0.4977,0.4978,0.4979,0.4979,0.498,0.4981,
                0.4981,0.4982,0.4982,0.4983,0.4984,0.4984,0.4985,0.4985,0.4986,0.4986,
                0.4987,0.4987,0.4987,0.4988,0.4988,0.4989,0.4989,0.4989,0.499,0.499,
                0.499,0.4991,0.4991,0.4991,0.4992,0.4992,0.4992,0.4992,0.4993,0.4993,
                0.4993,0.4993,0.4994,0.4994,0.4994,0.4994,0.4994,0.4995,0.4995,0.4995,
                0.4995,0.4995,0.4995,0.4996,0.4996,0.4996,0.4996,0.4996,0.4996,0.4997,
                0.4997,0.4997,0.4997,0.4997,0.4997,0.4997,0.4997,0.4997,0.4997,0.4998,
                0.4998,0.4998,0.4998,0.4998,0.4998,0.4998,0.4998,0.4998,0.4998,0.4998,
                0.4998,0.4998,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,
                0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,
                0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,0.4999,
                0.4);
        return($dnstable);
    }


    public function dist_norm_standard($x, $mean = 0, $standard_deviation = 1){

        $z = ($x-$mean) / $standard_deviation; //tipificaciion de la variable
        $n = sprintf("%.2f",$z); // Dos decimales
        $pos = abs($n)*100; // Prepara para buscar la posicion en la tabla 

        $tabl_distr_norm_standard = $this -> get_normal_dist_table();
        if( $pos  >= count($tabl_distr_norm_standard)){
            $val_norm = 0.5;
        }else{
            $val_norm = $tabl_distr_norm_standard [$pos  ];
        }


        if($x < $mean){
            $px = 0.5 - $val_norm;
        }elseif($x > $mean){
            $px = 0.5 + $val_norm;
        }elseif($x == $mean){
            $px = 0.5;
        }

        // FIX Error de aproximación PHP
        // 0.5 - 0.9998 = 0.00019999999999998
        $px = round( $px*10000 ) / 10000; // 0.0002

        if($px < 0)
            $px = 0;
        if($px > 1)
            $px = 1;

        //echo round(stats_dens_normal(1, 0, 1));
        return($px);

    }


}
