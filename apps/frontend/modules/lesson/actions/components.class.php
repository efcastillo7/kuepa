<?php

class lessonComponents extends sfComponents {

    public function executeModalform() {
        $id = $this->getVar('id');
        if ($id) {
            $lesson = Lesson::getRepository()->find($id);
        } else {
            //set default values
            $lesson = new Lesson();
            $profile_id = $this->getUser()->getGuardUser()->getProfile()->getId();
            $lesson->setProfileId($profile_id);
        }
        $this->form = new LessonForm($lesson, array('chapter_id' => $this->chapter_id));
    }

}