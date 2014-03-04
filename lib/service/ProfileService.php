<?php

class ProfileService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ProfileService;
        }

        return self::$instance;
    }

    public function findProfileByUsername($username, $query_params = null) {
        $query = Profile::getRepository()->createQuery('p')
                ->where('p.sfGuardUser.username = ?', $username);
        
        if($query_params){
            return $query->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $query->fetchOne();
    }

    public function findProfileByEmail($email, $query_params = null) {
        $query = Profile::getRepository()->createQuery('p')
                ->where('p.sfGuardUser.email_address = ?', $email);
        
        if($query_params){
            return $query->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $query->execute();
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

    public function generateUsername($first_name, $last_name = "", $counter = 0){
        $username = strtolower(preg_replace('[^a-zA-Z]', '', substr($first_name, 0, 3).substr($last_name, 0, 4))) . rand(0,999);
        while ( $this->findProfileByUsername($username)   ){
            $counter++;
            $username = $this->generateUsername($first_name, $last_name.$counter, $counter);
        }

        return($username);
    }

    public function generatedPassword($length = 8){
        $characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $password = '';

        for ($i = 0; $i < $length; $i ++)
        {
            $password .= $characters[rand() % strlen($characters)];
        }
        return $password;
    }

    public function generateMailAddress($first_name, $last_name = ""){
        return($first_name.'.'.$last_name.'@testmail.com');
    }


    public function importFromFile($file_path, $params){
      $lines = file($file_path, FILE_SKIP_EMPTY_LINES);
      $college_id = $params['college_id'];
      $separator = $params['separator'];
      $skip_first_line = $params['skip_first_line'];
      $array_errors = array();
      $array_ok = array();
      foreach ($lines as $key => $user) {
            if ( $skip_first_line == 1 && $key == 0){ 
              next($lines);
            }else if ( trim($user) != "" ){
             $user = explode("$separator",$user);
             if ( count($user) > 1 ){
               $firstname = $user[0];
               $lastname = $user[1];
               $email = trim($user[2]);
               $username = $user[3];
               $password = $user[4];

               // Si no esta el username (login) en el archivo se crea
               if ( trim($username) == "" ){
                  $username = $this->generateUsername($firstname, $lastname);
               }

               if ( trim($password) == "" ){
                $password = $this->generatedPassword();
               }

               if ( $email == "" ){
                 $email = $this -> generateMailAddress($firstname, $lastname);
               }

             if ($firstname == ""){
               $array_errors[] = "Error en linea $key, el campo Nombres esta vacio";
             } else if ($lastname == ""){
               $array_errors[] = "Error en linea $key, el campo Apellidos esta vacio";
             } else if ( $this->findProfileByUsername($username) ){
               $array_errors[] = "Error en linea $key, el Login $username ya existe";
             } else if ($email != "" && $this->findProfileByEmail($email)->getFirst() ){
               $array_errors[] = "Error en linea $key, el email $email ya existe";
             } else {

                $lastname = ucwords(strtolower($lastname));
                $firstname = ucwords(strtolower($firstname));
                //$user_id = UserManager :: create_user($user['FirstName'], $user['LastName'], $user['Status'], $user['Email'], $user['UserName'], $user['Password'], $user['OfficialCode'], api_get_setting('PlatformLanguage'), $user['PhoneNumber'], '', $user['AuthSource']);
                $params = array('first_name' => ucwords(strtolower($firstname)),
                                'last_name' =>  ucwords(strtolower($lastname)),
                                'email_address' => $email,
                                'nickname' => $username,
                                'password' => $password,
                                'code' => '',
                                'sex' => '');

                $profile = $this->addNewUser($params);
                $array_ok[] = array($firstname,$lastname,$email,$username,$password);
                if( (int)$college_id > 0 ){
                  CollegeService::getInstance()->addProfileToCollege($profile->getId(), $college_id);
                }

             } // else insert
             
            } else{ // end if count($user) > 1
               $array_errors[] = "El Separador de campo seleccionado $separator  no coincide con el archivo ";
            } 
            
          } // trim user
        } // foreach

      $message = 'El archivo ha sido importado';

      $response = array('message' => $message,
                        'success' => $array_ok,
                        'errors' => $array_errors);
      return($response);
    }


}
