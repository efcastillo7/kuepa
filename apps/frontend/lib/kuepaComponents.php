<?php

class kuepaComponents extends sfComponents {
    /**
     * 
     * @return Profile
     */
    public function getProfile() {
        return $this->getUser()->getGuardUser()->getProfile();
    }
    
    /**
     * 
     * @return sfGuardUser
     */
    public function getGuardUser() {
        return $this->getUser()->getGuardUser();
    }
}