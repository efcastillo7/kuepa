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

     $this->setLayout("layout_v2");
  }

  protected function registedDo(sfWebRequest $request){
  	$params = $request->getParameter($this->form->getName());

  	$this->form->bind($params);
  	if($this->form->isValid()){
  		//check first for code
  	   	if($params['code'] != ""){
  	   		$code = RegisterCode::getRepository()->find($params['code']);

  	   		if(!$code->isValidCode()){
  	   			//code is invalid
  	   			return;
  	   		}
  	   	}

  	   	$profile = ProfileService::getInstance()->addNewUser($params);

  	    //set flash
  	    $this->getUser()->setFlash('notice', "Ya puedes ingresar con tu usuario y contraseña!");

  	    //goto homepage
  	    $this->redirect("@homepage");

  	}

  	return;
  }
}
