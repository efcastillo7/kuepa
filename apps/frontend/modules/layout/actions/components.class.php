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

    public function executeStyles() {
        $style = "";

        if($this->getUser()->isAuthenticated()) {
            $style = $this->getUser()->getStyle();
        }

        $this->style = $style;
    }

    public function executeMessages(){
        //get full messages
        if($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getProfile();

            //get the first message
            $this->messages = FlashMessageService::getInstance()->getMessagesForUser($this->profile->getId(), $this->getUser()->getCollegeIds(), $this->profile->getCurrentRoute(), 1);

            //set message as viewed
            if($this->messages->count() > 0){
                $message = $this->messages->getFirst();
                FlashMessageService::getInstance()->setMessagesAsViewed($this->profile->getId(), $message->getId());                
            }
        }   
    }

}