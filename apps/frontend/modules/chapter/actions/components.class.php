<?php
 
class chapterComponents extends sfComponents
{
  public function executeModalform()
  {
    //set default values
    $chapter = new Chapter();
    $profile_id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $chapter->setProfileId($profile_id);

    $this->form = new ChapterForm($chapter, array('course_id' => $this->course_id));
  }
}