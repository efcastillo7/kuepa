<?php
class supportComponents extends sfComponents {

    public function executeModalform() {
        $id = $this->getVar('id');

        if($id) {
            $video_session      = VideoSession::getRepository()->find($id);
        } else {
            $video_session      = new VideoSession();
            $this->profile_id   = $this->getUser()->getGuardUser()->getProfile()->getId();
            $video_session->setProfileId($this->profile_id);
        }

        $this->form = new VideoSessionForm($video_session);
    }

    public function executeModalurl() {

        $this->id = $this->getVar('id');

    }

}