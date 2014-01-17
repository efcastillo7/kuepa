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

  public function executeProfilesForm(sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    $group = GroupsService::getInstance()->find($group_id);
   // $profiles = Profile::getRepository()->createQuery('p')->execute();
    $parent = GroupsService::getInstance()->getParent($group_id);
    if ( $parent ){ // if it is subgroup
      $profiles = GroupsService::getInstance()->getProfilesInGroup($parent->getId());
    }else{
      $profiles = GroupsService::getInstance()->getProfilesList($group_id);
    }

    $locals = array('profiles' => $profiles,
                    'group_id' => $group_id );
    $partial = $this->getPartial('form_profiles', $locals);

    $response = Array(
        'status' => "error",
        'template' => $partial,
        'code' => 200);

    return $this->renderText(json_encode($response));
  }

  public function executeProfilesList(sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    $group = GroupsService::getInstance()->find($group_id);
    //  
    $group_profiles = GroupsService::getInstance()->getProfilesInGroup($group_id);
    $locals = array('group_profiles' => $group_profiles,
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

    $this -> renderText( "count ".count($profile_ids) );
    $this->redirect('groups/index');
  }

  public function executeDeleteProfileGroup(sfWebRequest $request){
    $group_id = $request->getParameter('group_id');
    $profile_id = $request->getParameter('profile_id');
    GroupsService::getInstance()->removeProfileFromGroup($group_id, $profile_id);
    return( $this -> renderText("ok") );
  }

}
