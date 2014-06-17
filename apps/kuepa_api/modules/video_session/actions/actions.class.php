<?php

/**
 * video_session actions.
 *
 * @package    kuepa
 * @subpackage video_session
 * @author     CristalMedia | KiBind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class video_sessionActions extends sfActions {

    /**
     * PUT /video_session/{id}
     * @param sfWebRequest $request
     * @return json response
     * @throws BadRequest
     */
    public function executeEdit(sfWebRequest $request) {

        $response   = Array(
            'status'    => "error",
            'template'  => "Error inesperado",
            'code'      => 400
        );

        try {

            $params = $request->getPostParameters();
            $id     = $request->getParameter("id");
            $url    = $request->getParameter("url");
            $gid    = $request->getParameter("gid");
            $appId  = "&gid=".VideoSessionService::APP_ID_INT;
            $dataPa = "&gd=".urlencode(json_encode(array(
                "video_session_id"  => $id,
                "host_person_id"    => $gid
            )));

            if (empty($id) || empty($url) || empty($gid)) {
                $response["template"] = "Faltan parametros";
                throw new BadRequest;
            }

            $video_session  = VideoSessionService::getInstance()->editVideoSession($id, array( "url" => $url.$appId.$dataPa, "status" => "started" ) + $params );

            if(!$video_session){
                $response["template"] = "¡La sesión de video #{$id} no existe!";
                throw new BadRequest;
            }else{
                $this->getResponse()->setStatusCode(201);
                $response["status"] = "success";
                $response["template"] = "Sesión #{$id} editada correctamente";
            }

        } catch (BadRequest $e) {
            $this->getResponse()->setStatusCode(400);
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);
        }

        return $this->renderText(json_encode($response));
    }

    /**
     * GET /video_session
     * @param sfWebRequest $request
     * @return json response
     * @throws BadRequest
     */
    public function executeList(sfWebRequest $request){
        $id = $request->getParameter("id");

        if (empty($id)) {
            throw new BadRequest;
        }

        $profile_id = $this->getUser()->getProfile()->getId();

        try {
            $data = VideoSessionService::getInstance()->getVideoSessionFromIdArray($id);

            //inject profile id
            foreach ($data as $video) {
                if($video['platform'] == VideoSessionService::PLATFORM_HANGOUTS){
                    $video['url'] = VideoSessionService::getInstance()->injectProfileId($video['url'],$profile_id);
                }else if($video['platform'] == VideoSessionService::PLATFORM_EXTERNAL && $video['url'] != "" && $video['status'] == VideoSessionService::STATUS_PENDING){
                    if(strtotime($video['scheduled_for']) > time()){
                        VideoSessionService::getInstance()->startVideoSession($video['id']);
                    }
                }
            }
            
            return $this->renderText(json_encode($data));
        } catch (BadRequest $e) {
            $this->getResponse()->setStatusCode(400);
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);
        }

        return $this->renderText(json_encode(array('status' => 'error')));
    }

    /**
     * PUT /video_session/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeCreate(sfWebRequest $request) {}

    /**
     * GET /video_session/{id}
     * GET /video_session/{ids}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        $profile_id = $this->getUser()->getProfile()->getId();
        die();

        $id = $request->getParameter("id");

        if($id){
            $data = VideoSessionService::getInstance()->getVideoSessionFromIdArray($id);

            //inject profile id
            foreach ($data as $video) {
                if($video['platform'] == VideoSessionService::PLATFORM_HANGOUTS){
                    $video['url'] = VideoSessionService::getInstance()->injectProfileId($video['url'],$profile_id);
                }else if($video['platform'] == VideoSessionService::PLATFORM_EXTERNAL){
                    if(strtotime($video['scheduled_for']) > time()){
                        VideoSessionService::getInstance()->startVideoSession($video['id']);
                    }
                }
            }
            
            return $this->renderText(json_encode($data));
        }
    }

    /**
     * DELETE /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {}
    
    /**
     * GET /video_session/{video_session_id}/participantes
     * GET /video_session/{ids}
     *
     * @param sfRequest $request A request object
     */
    public function executeParticipants(sfWebRequest $request) {
        $video_session_id  = $request->getParameter("video_session_id");
        $participants = VideoSessionService::getInstance()->getParticipants($video_session_id);
        
        $data = array();
        
        foreach( $participants as $profile )
        {          
            $videoSessionParticipant = $profile->getVideoSessionParticipant();
                          
            $time = strtotime( $videoSessionParticipant->getUpdatedAt() ) - strtotime( $videoSessionParticipant->getCreatedAt() );
            $time = ceil($time / 60);
            
            $data[] = array(
                        'first_name' => $profile->getFirstName(),
                        'last_name' => $profile->getLastName(),
                        'time' => $time
                      );
        }
                
        return $this->renderText(json_encode($data));
    }

}
