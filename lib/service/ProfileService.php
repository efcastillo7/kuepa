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

    public function addNewUser($params){
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
                ->setSex($params['sex'])
                ->save();

        return $profile;
    }
}
