<?php

/**
 * video_session actions.
 *
 * @package    kuepa
 * @subpackage video_session
 * @author     cristalmedia
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class supportActions extends sfActions {

    /**
     *
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request) {

        $this->profile_id               = $this->getUser()->getGuardUser()->getProfile()->getId();
        $this->pending_video_sessions   = VideoSessionService::getInstance()->getPendingSupportSessions();
        $this->historic_video_sessions  = VideoSessionService::getInstance()->getHistoricSupportSessions();

    }

    /**
     * Fast-creates a support video session
     * @param sfWebRequest $request
     * @return type
     */
    public function executeCreate(sfWebRequest $request) {
        header('Access-Control-Allow-Origin: *');

        $profile_id = $request->getParameter("profile_id");
        $url        = $request->getParameter("url");
        $gId        = $request->getParameter("gid");

        $video_session  = new VideoSession();
        $video_session
                ->setStudentProfileId( $profile_id )
                ->setUrl($url)
                ->setScheduledFor( date("Y-m-d H:i:s") )
                ->setType( VideoSessionService::TYPE_SUPPORT )
                ->save();

        $appId  = strpos($url, "?") > -1 ? "&" : "?"."gid=".VideoSessionService::APP_ID_INT;
        $dataPa = "&gd=".urlencode(json_encode(array(
            "video_session_id"  => $video_session->getId(),
            "host_person_id"    => $gId,
            "type"              => VideoSessionService::TYPE_SUPPORT
        )));

        $video_session->setUrl($url.$appId.$dataPa);
        $video_session->save();

        $response   = Array(
            'status'    => "success",
            'template'  => "Ha creado la sesión de soporte satisfactoriamente",
            'id'        => $video_session->getId(),
            'code'      => 200
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
            'template'  => "¡La sesión de soporte #{$id} no existe!",
            'code'      => 400
        );

        $video_session  = VideoSession::getRepository()->find($id);

        if($video_session){
            $video_session->setStatus("ended");
            $video_session->save();

            $response['template']   = "Ha finalizado la sesión de soporte satisfactoriamente";
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
    public function executeUpdate_profile(sfWebRequest $request){

        $id     = $request->getParameter("support_id");

        $response   = Array(
            'status'    => "error",
            'template'  => "¡La sesión de soporte #{$id} no existe!",
            'code'      => 400
        );

        $video_session  = VideoSession::getRepository()->find($id);

        if($video_session){

            $currentPID = $video_session->getProfileId();

            if(!empty($currentPID)){
                $response['template']   = "La sesión de video ya tiene asignado un agente de soporte";
                return $this->renderText(json_encode($response));
            }

            $video_session
                ->setProfileId( $this->getUser()->getGuardUser()->getProfile()->getId() )
                ->setStatus( VideoSessionService::STATUS_STARTED )
                ->save();

            $response['template']   = "Ha grabado la url de la sesión soporte satisfactoriamente";
            $response['status']     = "success";
            $response['code']       = 200;
        }

        return $this->renderText(json_encode($response));

    }

}
