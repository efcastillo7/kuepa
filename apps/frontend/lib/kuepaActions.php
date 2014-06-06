<?php

class kuepaActions extends sfActions {
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

    public function checkAccountStatus(){
        $user = $this->getUser();
        if($user->isValidAccount()){
            return true;
        }else{
            $user->signOut();
            $this->redirect("@account_expired");
        }
    }

    public function preExecute() {
        parent::preExecute();

        //get context
        $context = $this->getContext();
        //get module name
        $module = $context->getModuleName();
        //get action name
        $action = $context->getActionName();
        
        //update location
        if($profile = $this->getProfile()){
          $profile->setCurrentModule($module)
                  ->setCurrentAction($action)
                  ->save();
        }
        
        //check for course credentials
        $request = $this->getRequest();
        
        if(($course_id = $request->getParameter('course_id'))){
            $this->forward404Unless($this->getUser()->hasCredential('course_' . $course_id));
        }

      }
      
}