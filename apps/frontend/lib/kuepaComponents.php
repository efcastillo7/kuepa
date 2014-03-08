<?php

class kuepaComponents extends sfComponents {
    /**
     * 
     * @return Profile
     */
    public function getProfile() {
        return $this->getUser()->getProfile();
    }
    
    /**
     * 
     * @return sfGuardUser
     */
    public function getGuardUser() {
        return $this->getUser()->getGuardUser();
    }
}