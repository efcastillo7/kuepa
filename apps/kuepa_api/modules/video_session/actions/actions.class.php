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
        $profile_id = $this->getUser()->getProfile()->getId();

        $id = $request->getParameter("id");

        if (empty($id)) {
            throw new BadRequest;
        }

        try {
            $data = VideoSessionService::getInstance()->getVideoSessionFromIdArray($id);
            
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

        $id = $request->getParameter("id");

        if($id){
            $data = VideoSessionService::getInstance()->getVideoSessionFromIdArray($id);
            
            return $this->renderText(json_encode($data));
        }
    }

    /**
     * DELETE /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {}

}
