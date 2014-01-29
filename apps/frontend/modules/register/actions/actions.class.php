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
    $code = $request->getParameter("code", "" );

    $this->form = new sfRegisterDemoUserForm(array('code' => $code), array('validate-code' => false));

  	if($request->isMethod("POST")){
  		$this->registedDo($request);
  	 }

     $this->setLayout("layout_v2");
  }

  protected function registedDo(sfWebRequest $request){
  	$params = $request->getParameter($this->form->getName());

  	$this->form->bind($params);
  	if($this->form->isValid()){
        $params['nickname'] = $params['email_address'];
        $params['sex'] = 'M';
        
  	   	$profile = ProfileService::getInstance()->addNewUser($params);

        if($params['code'] == "PANAMERICANA"){
          CollegeService::getInstance()->addProfileToCollege($profile->getId(), 1);
        }

        //signin
        $this->getUser()->signIn($profile->getSfGuardUser());

  	    //set flash
  	    $this->getUser()->setFlash('notice', "Ya puedes ingresar con tu usuario y contraseña!");

  	    //goto homepage
  	    $this->redirect("@homepage");

  	}

  	return;
  }
}
