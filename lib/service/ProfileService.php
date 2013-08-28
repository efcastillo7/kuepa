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
}
