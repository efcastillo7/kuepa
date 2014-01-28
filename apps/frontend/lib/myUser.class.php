<?php

class myUser extends sfGuardSecurityUser {

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
        parent::signIn($user, $remember, $con);
    }
    
    public function signOut() {
        parent::signOut();
    }

}
