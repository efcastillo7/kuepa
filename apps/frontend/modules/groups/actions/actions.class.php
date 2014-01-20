<?php

/**
 * groups actions.
 *
 * @package    kuepa
 * @subpackage groups
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupsActions extends kuepaActions
{
  public function executeIndex(sfWebRequest $request)
  {
    // $this->groups = Groups::getRepository()->createQuery('g')->execute();
     $this->groups = GroupsService::getInstance()->getGroupsByLevel(0);
     $this->profile =  $this->getProfile();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $values = $request->getParameter('groups');
    $parent_id = $request->getParameter('parent_id');

    $values['creator_id'] = $this->getProfile()->getId();
    $group = GroupsService::getInstance()->save($values);

    if ( (int)$parent_id > 0){
      GroupsService::getInstance()->addChildToGroup( $parent_id, $group->getId() );
    }

    $this->redirect('groups/index');
  }

  public function executeDeleteGroup( sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    GroupsService::getInstance()->deleteGroup( $group_id );

    $response = Array(
        'status' => "error",
        'template' => "",
        'code' => 200);

    return $this->renderText(json_encode($response));
  }

  public function executeProfileSearch(sfWebRequest $request){
    $kind = $request->getParameter('kind');
    $group_id = $request->getParameter('group_id');
    $search_text =  $request->getParameter('search_text');
    $group = GroupsService::getInstance()->find($group_id);
    $filters = array();
    if ( $search_text != ""){
     $filters[] = array("cond" => "(p.first_name LIKE ? OR p.last_name LIKE ?) ", 
                        "value" => array("%$search_text%", "%$search_text%") );
    }

    $profiles = GroupsService::getInstance()->getProfiles($group_id, $kind, $filters);

    $locals = array('profiles' => $profiles,
                    'group' => $group,
                    'search_text' => $search_text );
    if ( $kind == "profiles"){
      $partial = $this->getPartial('form_profiles', $locals);
    }else if( $kind == "group_profiles"){
      $partial = $this->getPartial('profiles_list', $locals);
    }

    $response = Array(
        'status' => "error",
        'template' => $partial,
        'code' => 200);

    return $this->renderText(json_encode($response));

  }

  /**
  * TODO: To improve, we can call the ProfileSearch
  * instead of calling ProflesForm and ProfilesList
  * just sending the "kind" param
  */
  public function executeProfilesForm(sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    $group = GroupsService::getInstance()->find($group_id);
    $profiles = GroupsService::getInstance()->getProfiles($group_id, "profiles");

    $locals = array('profiles' => $profiles,
                    'group' => $group );
    $partial = $this->getPartial('form_profiles', $locals);

    $response = Array(
        'status' => "error",
        'template' => $partial,
        'code' => 200);

    return $this->renderText(json_encode($response));
  }


  /**
  * TODO: To improve, we can call the ProfileSearch
  * instead of calling ProflesForm and ProfilesList
  * just sending the "kind" param
  */
  public function executeProfilesList(sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    $group = GroupsService::getInstance()->find($group_id);
    $profiles = GroupsService::getInstance()->getProfiles($group_id, "group_profiles");

    $locals = array('profiles' => $profiles,
                    'group' => $group );
    $partial = $this->getPartial('profiles_list', $locals);
    $response = Array(
        'status' => "error",
        'template' => $partial,
        'code' => 200
    );

    return $this->renderText(json_encode($response));
  }

  public function executeAddProfiles(sfWebRequest $request){

    $profile_ids = $request -> getParameter('profile_ids');
    $group_id = $request -> getParameter('group_id');
    $GroupsService = GroupsService::getInstance();
    if ( count($profile_ids) > 0 ){
      foreach ($profile_ids as $key => $profile_id) {
        $GroupsService->addProfileToGroup($group_id, $profile_id);
      }
    }

    return( $this -> renderText( "count ".count($profile_ids) ) );
   // $this->redirect('groups/index');
  }

  public function executeDeleteProfileGroup(sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    $profile_id = $request->getParameter('profile_id');
    GroupsService::getInstance()->removeProfileFromGroup($group_id, $profile_id);
    return( $this -> renderText("ok") );
  }

}
