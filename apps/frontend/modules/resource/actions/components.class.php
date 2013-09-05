<?php
 
class resourceComponents extends sfComponents
{
  public function executeModalform()
  {
    //set default values
    $resource = new Resource();
    $profile_id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $resource->setProfileId($profile_id);

    $this->form = new ResourceForm($resource);
  }
}