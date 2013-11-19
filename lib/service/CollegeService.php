<?php

class CollegeService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new CollegeService;
        }

        return self::$instance;
    }

    public function addProfileToCollege($profile_id, $college_id){
        $pc = new ProfileCollege();
        $pc->setProfileId($profile_id)
           ->setCollegeId($college_id)
           ->save();
    }

}
