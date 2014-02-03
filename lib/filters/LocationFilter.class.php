<?php 

class LocationFilter extends sfFilter{
    public function execute($filterChain){
        if ($this->isFirstCall()){
            //get context
            $context = $this->getContext();
            //get module name
            $module = $context->getModuleName();
            //get action name
            $action = $context->getActionName();
            
            //get country code
            $user = $context->getUser();

            if($user){
              $profile = $user->getGuardUser()->getProfile();
              $profile->setCurrentModule($module)
                      ->setCurrentAction($action)
                      ->save();
            }
        }

        $filterChain->execute();
    }
}