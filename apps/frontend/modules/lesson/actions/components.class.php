<?php
 
class lessonComponents extends sfComponents
{
  public function executeModalform()
  {
    //set default values
    $lesson = new Lesson();
    $profile_id = $this->getUser()->getGuardUser()->getProfile()->getId();
    $lesson->setProfileId($profile_id);

    $this->form = new LessonForm($lesson);
  }
}