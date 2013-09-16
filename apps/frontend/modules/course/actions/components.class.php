<?php

class courseComponents extends sfComponents {

    public function executeModalform() {
        $id = $this->getVar('id');
        if($id) {
            $course = Course::getRepository()->find($id);
        } else {
            //set default values
            $course = new Course();
            $profile_id = $this->getUser()->getGuardUser()->getProfile()->getId();
            $course->setProfileId($profile_id);
        }

        $this->form = new CourseForm($course);
    }

}