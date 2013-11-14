<?php

class kuepaActions extends sfActions {
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

    public function checkAccountStatus(){
        $user = $this->getUser();
        if($user->isValidAccount()){
            return true;
        }else{
            $user->signOut();
            $this->redirect("@account_expired");
        }
    }
}