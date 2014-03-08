<?php

class myUser extends sfGuardSecurityUser {

    
    const SFGUARD_USER_ATTR = 'sfGuarUser';
    const PROFILE_ATTR = 'profile';
    
    public function isValidAccount() {
        //check if account is enabled - TODO: Add field
        //check if account date is valid
        $date = $this->getProfile()->getValidUntil();
        if ($date) {
            $valid_until = strtotime($date);
            $diff = $valid_until - time();

            return $diff > 0;
        }

        return true;
    }
    
    public function signIn($user, $remember = false, $con = null) {
        //entra cuando hay login succesfull
        //setear cultura de usuario, zona horaria, etc.
                
        $this->setUser($user);
                
        parent::signIn($user, $remember, $con);
    }
    
    public function signOut() {
        parent::signOut();
        $this->clearCurrentUser();
    }
    
    protected function setUser($user)
    {
        $profile = $user->getProfile();
        $this->setAttribute(self::PROFILE_ATTR, $user->getProfile());
        
        $user->setProfile( $profile );
        $this->setAttribute(self::SFGUARD_USER_ATTR, $user);
    }
    
    public function getGuardUser()
    {
        return sfContext::getInstance()->getUser()->getAttribute(self::SFGUARD_USER_ATTR);
    }

    public function getProfile()
    {
        return sfContext::getInstance()->getUser()->getAttribute(self::PROFILE_ATTR);
    }
    
    protected function clearCurrentUser()
    {
        return $this->setAttribute(self::SFGUARD_USER_ATTR, null);
        return $this->setAttribute(self::PROFILE_ATTR, null);
    }

}
