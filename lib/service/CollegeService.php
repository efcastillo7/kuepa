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
    
    public function getByProfileId($profile_id){
        return College::getRepository()
                    ->createQuery('c')
                    ->innerJoin('c.ProfileCollege pc')
                    ->where('pc.profile_id = ?', $profile_id)
                    ->fetchOne();
    }

}
