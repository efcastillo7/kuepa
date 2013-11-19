<?php

/**
 * register actions.
 *
 * @package    kuepa
 * @subpackage register
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new sfRegisterUserForm();

	if($request->isMethod("POST")){
		$this->registedDo($request);
	}
  }

  protected function registedDo(sfWebRequest $request){
  	$params = $request->getParameter($this->form->getName());

  	$this->form->bind($params);
  	if($this->form->isValid()){
  		$sfUser = new sfGuardUser();
  		$sfUser->setFirstName($params['first_name'])
  			   ->setLastName($params['last_name'])
  			   ->setEmailAddress($params['email_address'])
  			   ->setUsername($params['nickname'])
  			   ->setPassword($params['password']);
	   $sfUser->save();

  	    $profile = new Profile();
  	    $profile->setSfGuardUserId($sfUser->getId())
  	    		->setNickname($sfUser->getUsername())
  	    		->setFirstName($sfUser->getFirstName())
  	    		->setLastName($sfUser->getLastName())
  	    		->setBirthdate('')
  	    		->setSex($params['sex'])
  	    		->save();

  	    //set flash
  	    
  	    //goto homepage
  	    $this->redirect("@homepage");

  	}

  	return;
  }
}
