<?php

/**
 * video_session actions.
 *
 * @package    kuepa
 * @subpackage video_session
 * @author     cristalmedia
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class video_sessionActions extends sfActions {

    /**
     *
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request) {

        $this->profile_id                   = $this->getUser()->getGuardUser()->getProfile()->getId();
        $this->google_id                    = $this->getUser()->getGuardUser()->getProfile()->getGoogleId();
        $this->next_own_video_sessions      = VideoSessionService::getInstance()->getNextVideoSessionsFromUser( $this->profile_id );
        $this->prev_own_video_sessions      = VideoSessionService::getInstance()->getPrevVideoSessionsFromUser( $this->profile_id );
        $this->next_related_video_sessions  = VideoSessionService::getInstance()->getNextVideoSessionsForUser( $this->profile_id );
        $this->prev_related_video_sessions  = VideoSessionService::getInstance()->getPrevVideoSessionsForUser( $this->profile_id );

    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeCreate(sfWebRequest $request) {

        $id     = $request->getParameter("id");
        if($id) {
            $video_session      = VideoSession::getRepository()->find($id);
        } else {
            $video_session      = new VideoSession();
            $this->profile_id   = $this->getUser()->getGuardUser()->getProfile()->getId();
            $video_session->setProfileId($this->profile_id);
        }

        $form = new VideoSessionForm($video_session);

        $response   = Array(
            'status'    => "error",
            'template'  => "",
            'code'      => 400
        );

        $params = $request->getParameter( $form->getName() );

        $form->bind(
            $params,
            $request->getFiles( $form->getName() )
        );

        if ($form->isValid()) {

            $video_session          = $form->save();
            $response['template']   = "Ha ".($id?"editado":"creado")." la sesión de video satisfactoriamente";
            $response['status']     = "success";

            } else {

            $response['template']   = $this->getPartial("form", array('form' => $form));
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeUpdate(sfWebRequest $request){

        header('Access-Control-Allow-Origin: *');

        $id     = $request->getParameter("video_session_id");
        $url    = $request->getParameter("url");
        $gId    = $request->getParameter("gid");

        $response   = Array(
            'status'    => "error",
            'template'  => "¡La sesión de video #{$id} no existe!",
            'code'      => 400
        );

        $video_session  = VideoSession::getRepository()->find($id);

        if($video_session){

            $appId  = strpos($url, "?") > -1 ? "&" : "?"."gid=".VideoSessionService::APP_ID_INT;
            $dataPa = "&gd=".urlencode(json_encode(array(
                "video_session_id"  => $id,
                "host_person_id"    => $gId,
                "type"              => $video_session->getType()
            )));

            $video_session->setUrl($url.$appId.$dataPa);
            $video_session->setStatus("started");
            $video_session->save();

            $response['template']   = "Ha grabado la url de la sesión de video satisfactoriamente";
            $response['status']     = "success";
        }

        return $this->renderText(json_encode($response));

    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeEdit(sfWebRequest $request){
        $id             = $request->getParameter("id");
        $video_session  = VideoSession::getRepository()->find($id);
        $form           = new VideoSessionForm($video_session);

        $response = array(
            'template' => $this->getPartial( "form", array('form' => $form) )
        );

        return $this->renderText(json_encode($response));
    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeFinish(sfWebRequest $request){

        $id         = $request->getParameter("id");
        $response   = Array(
            'status'    => "error",
            'template'  => "¡La sesión de video #{$id} no existe!",
            'code'      => 400
        );

        $video_session  = VideoSession::getRepository()->find($id);

        if($video_session){
            $video_session->setStatus("ended");
            $video_session->save();

            $response['template']   = "Ha finalizado la sesión de video satisfactoriamente";
            $response['status']     = "success";
            $response['code']       = 200;
        }

        return $this->renderText(json_encode($response));

    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeGet_course_chapters(sfWebRequest $request){
        $id         = $request->getParameter("id");
        $course     = Course::getRepository()->find($id);
        $chapters   = $course->getChapters();
        $a_chapters = array();

        foreach($chapters as $chapter){
            $a_chapters[] = array(
                "id"    => $chapter->getId(),
                "name"  => $chapter->getName(),
            );
        }

        $response   = Array(
            'status'    => "success",
            'template'  => $a_chapters,
            'code'      => 200
        );

        return $this->renderText( json_encode($response) );

    }

    /**
     *
     * @param sfWebRequest $request
     * @return type
     */
    public function executeUpdate_user_googleid(sfWebRequest $request){
        $id         = $this->getUser()->getGuardUser()->getProfile()->getId();
        $google_id  = $request->getParameter("google_id");
        $response   = Array(
            'status'    => "error",
            'template'  => "¡El usuario #{$id} no existe!",
            'code'      => 400
        );

        $profile  = Profile::getRepository()->find($id);

        if($profile){
            $profile->setGoogleId($google_id);
            $profile->save();

            $response['template']   = "Ha guardado su Google ID satisfactoriamente";
            $response['status']     = "success";
        }

        return $this->renderText(json_encode($response));
    }

}
