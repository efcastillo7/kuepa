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

    public function getProfilesListQuery($college_id){

        if($college_id){
            $college = College::getRepository()->find($college_id);

            $show_status = explode(",", $college->getShowStatus());

            //if college shows all courses
            if(!count($show_status) || in_array(ProfileLearningPath::ALL, $show_status)){
                $query = Profile::getRepository()->createQuery('p')
                    ->innerJoin('p.sfGuardUser sgu')
                    ->innerJoin('sgu.sfGuardUserGroup sgug')
                    ->innerJoin('sgug.Group sgg')
                    ->innerJoin("p.ProfileCollege pc")
                    //todo remove
                    ->andWhereIn('sgg.id', array(1,2,7,8))
                    //end todo
                    ->andWhere('sgu.is_active = true')
                    ->whereIn("pc.college_id", $college_id);

            }else if(in_array(ProfileLearningPath::IN_PROGRESS, $show_status)){
                //show only current students
                $query = Profile::getRepository()->createQuery('p')
                    ->innerJoin('p.sfGuardUser sgu')
                    ->innerJoin('sgu.sfGuardUserGroup sgug')
                    ->innerJoin('sgug.Group sgg')
                    ->innerJoin("p.ProfileCollege pc")
                    ->innerJoin("p.ProfileLearningPath plp")
                    //todo remove
                    ->andWhereIn('sgg.id', array(1,2,7,8))
                    //end todo
                    ->andWhere('sgu.is_active = true')
                    ->whereIn("pc.college_id", $college_id);

            }

            return $query;
        }

        return null;
    }

}
