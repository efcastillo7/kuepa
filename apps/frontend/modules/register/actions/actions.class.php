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

  public function executeBogotadocente(sfWebRequest $request)
  {
    $code = $request->getParameter("code", "" );

    $this->form = new sfRegisterDocenteBogotaUserForm(array('code' => $code), array('validate-code' => false));

    if($request->isMethod("POST")){
      $this->registedDobogota($request);
     }

     $this->getResponse()->addStylesheet("/styles/css/bogota.css", 'last');

     $this->setLayout("layout_v2");
  }

  protected function registedDobogota(sfWebRequest $request){
    $params = $request->getParameter($this->form->getName());

    $this->form->bind($params);
    if($this->form->isValid()){
        $params['nickname'] = $params['email_address'];
        $params['sex'] = 'M';
        $params['timezone'] = 'America/Bogota';
        $params['culture'] = 'es_CO';
        
        $profile = ProfileService::getInstance()->addNewUser($params, 8);

        CollegeService::getInstance()->addProfileToCollege($profile->getId(), 11);

        //signin
        $this->getUser()->signIn($profile->getSfGuardUser());

        //set flash
        $this->getUser()->setFlash('notice', "Ya puedes ingresar con tu usuario y contraseña!");

        //goto homepage
        $this->redirect("@homepage");

    }

    return;
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

  public function executeBogota(sfWebRequest $request){
    header('Access-Control-Allow-Origin: *');

    $values = $request->getParameter("register"); 
    $response = array(
      'status' => 'error',
      'message' => 'User not found',
    );


    $firstname_full = isset($values['firstname']) ? trim($values['firstname']) : "";
    $lastname_full = isset($values['lastname']) ? trim($values['lastname']) : "";
    $dni = isset($values['document']) ? trim($values['document']) : "";

    if(empty($firstname_full) || empty($lastname_full) || empty($dni) ){
      return $this->renderText(json_encode($response));
    }

    $firstnames = explode(" ", $firstname_full);
    $lastnames = explode(" ", $lastname_full);

    //search for user
    $query = Profile::getRepository()->createQuery('p')
              ->innerJoin("p.sfGuardUser sfu")
              ->where("sfu.email_address like '%@bogota.co'");
              // ->where("levenshtein( ?, first_name) < 5")

    //search fullfields
    $query->andWhere("first_name like ? and last_name like ? and local_id like ?", 
      array('%' . $firstname_full . '%', 
            '%' . $lastname_full . '%',
            '%' . $dni . '%'));

    $results = $query->execute();

    if ($results->count() == 1) {
      $response['status'] = 'ok';
      $response['message'] = 'User found';
      $response['username'] = $results[0]->getNickname();
      $response['password'] = $results[0]->getLocalId();
    }else{
      $response['status'] = 'filter';
    }

    return $this->renderText(json_encode($response));

  }

  public function executeLogin(sfWebRequest $request)
  {
    header('Access-Control-Allow-Origin: *');
    
    $username = trim($request->getPostParameter("username", ""));
    $password = trim($request->getPostParameter("password", ""));

    if (!empty($username) && !empty($password) && $request->isMethod('post')){
      $user = ProfileService::getInstance()->isValidUser($username,$password);
      if($user){
        // $this->getUser()->signin($user);
        $token = ProfileService::getInstance()->generateLoginToken($user->getProfile());
        $this->getResponse()->setStatusCode(200);

        return $this->renderText(json_encode(array('status' => 'ok', 'token' => $token)));
      }
    }

    $this->getResponse()->setHeaderOnly(true);
    $this->getResponse()->setStatusCode(401);

    return sfView::NONE;
  }

  public function executeLoginbytoken(sfWebRequest $request)
  {
    $token = trim($request->getParameter("token", ""));

    if (!empty($token)){
      $token = ProfileService::getInstance()->getLoginToken($token);
      if($token){
        $user = $token->getSfGuardUser();
        $this->getUser()->signin($user);

        //delete token
        $token->delete();

        //redirect to home
        $this->redirect("home/index");
      }
    }

    $this->getResponse()->setHeaderOnly(true);
    $this->getResponse()->setStatusCode(401);

    return sfView::NONE;
  }


}
