<?php

class layoutComponents extends kuepaComponents {

    public function executeNavigation() {
        $this->profile = null;
        
        if($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getProfile();
        }
    }

    public function executeNavigationV2() {
        $this->profile = null;
        
        if($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getProfile();
        }
    }

}