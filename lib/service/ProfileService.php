<?php

class ProfileService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ProfileService;
        }

        return self::$instance;
    }

    public function findProfilesByName($string, $query_params = null) {
        $query = Profile::getRepository()->createQuery('p')
                ->addWhere('p.sfGuardUser.first_name like ?', "%$string%")
                ->orWhere('p.sfGuardUser.last_name like ?', "%$string%");
        
        if($query_params){
            return $query->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $query->execute();
    }

    public function addCoursesByCode($profile_id, $code){
        $rcode = RegisterCode::getRepository()->find($code);
        $profile = Profile::getRepository()->find($profile_id);

        if($rcode && $profile){

        }
    }

    public function getFriends($profile_id){
        //fetch all users that are in any course with him
        $profile = Profile::getRepository()->find($profile_id);
        $sql_college = "";

        if($profile->getColleges()->count()){
            $college_id = $profile->getColleges()->getFirst()->getId();
            $sql_college = "(select profile_id from profile_college where college_id = $college_id)";
            $subquery = "SELECT distinct(profile_id) FROM ($sql_college UNION (SELECT distinct(profile_id) from profile_learning_path where component_id in (select component_id from profile_learning_path where profile_id = $profile_id)) ) t1 where profile_id != $profile_id";
        }else{
            $subquery = "SELECT distinct(profile_id) FROM (SELECT distinct(profile_id) FROM profile_learning_path WHERE component_id IN (SELECT component_id FROM profile_learning_path WHERE profile_id = $profile_id)) t1 where profile_id != $profile_id";
        }
        
        $rs = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($subquery);
        $ids = array();
        foreach($rs as $r){
            $ids[] = $r['profile_id'];
        }

        //subquery
        $q = Profile::getRepository()->createQuery('p')
                ->whereIn('id', $ids);

        // $q = Profile::getRepository()->createQuery('p')
        //         ->innerJoin('p.ProfileLearningPath plp')
        //         ->innerJoin('p.sfGuardUser sgu')
        //         ->innerJoin('sgu.sfGuardUserGroup sgug')
        //         ->innerJoin('sgug.Group sgg')
        //         ->where('plp.component_id = ?', $course_id)
        //         ->andWhere('sgg.name = ?', 'estudiantes');

        return $q->execute();
    }

    public function addNewUser($params, $type = 2){
        $sfUser = new sfGuardUser();
        $sfUser->setFirstName($params['first_name'])
               ->setLastName($params['last_name'])
               ->setEmailAddress($params['email_address'])
               ->setUsername($params['nickname'])
               ->setPassword($params['password']);
        $sfUser->save();

        $profile = new Profile();
        $profile->setSfGuardUserId($sfUser->getId())
                ->setNickname($sfUser->getUsername())
                ->setFirstName($sfUser->getFirstName())
                ->setLastName($sfUser->getLastName())
                ->setBirthdate('')
                ->setSex($params['sex']);

        //set user as student
        $group = new sfGuardUserGroup();
        $group->setUserId($sfUser->getId())
              ->setGroupId($type)
              ->save();

        //save!
        $profile->save();

        if($params['code']){
            $code = RegisterCode::getRepository()->find($params['code']);

            //if exists and is valid
            if($code && $code->isValidCode()){
                //set expired date by date
                $to_date = null;
                if($code->getValidUntil()){
                    $to_date = $code->getValidUntil();
                }

                //expired date by days
                if(!$to_date && $code->getValidDays() && $code->getValidDays() > 0){
                    $days = $code->getValidDays();
                    $to_date = date("Y-m-d", strtotime("now +$days days"));
                }

                if($to_date){
                    $profile->setValidUntil($to_date);
                    $profile->save();
                }

                //set college if any
                if($code->getCollegeId()){
                    CollegeService::getInstance()->addProfileToCollege($profile->getId(), $code->getCollegeId());
                }

                //set courses if any
                foreach($code->getCourse() as $course){
                    CourseService::getInstance()->addStudent($course->getId(), $profile->getId());
                }

                //update code use
                $code->setInUse(true)
                     ->setProfileId($profile->getId())
                     ->save();
            }
        }

        return $profile;
    }
}
