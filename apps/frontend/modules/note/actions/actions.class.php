<?php

/**
 * chapter actions.
 *
 * @package    kuepa
 * @subpackage chapter
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class noteActions extends kuepaActions {

    /**
     * Will return a formatted list of notes by component_id for the logged user
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
        $component_id = $request->getParameter('component_id');
        
        
        $parameters = Array(
            'notes' => NoteService::getInstance()->getNotes($this->getProfile()->getId(), $component_id)
        );
        
        $response = Array(
            'status' => 'success',
            'template' => $this->getPartial('list', $parameters)
        );

        return $this->renderText(json_encode($response));
    }

    public function executeAdd(sfWebRequest $request){
        $response = array('status' => 'invalid request', 'code' => 400);
        $values = $request->getPostParameters();

        if($request->isMethod('POST') && isset($values['content']) && $values['content'] != ""){

            //check values
            $this->note = NoteService::getInstance()->createNote($this->getProfile()->getId(), $values['resource_id'], $values['content']);

            $response = array('status' => 'ok', 'code' => 201);

            if($request->isXmlHttpRequest()) {
              $response['template'] = $this->getPartial('views/resource/note');
            }
        }

        $this->getResponse()->setStatusCode($response['code']);
        return $this->renderText(json_encode($response));
    }

    public function executeGet(sfWebRequest $request){
        $response = array('status' => 'invalid request', 'code' => 400);

        if($request->isMethod('GET')){
            $values = $request->getGetParameters();

            //check values
            $notes = NoteService::getInstance()->getNotes($this->getProfile()->getId(), $values['resource_id'], 
                        array('params' => array(),
                              'hydration_mode' => Doctrine_Core::HYDRATE_ARRAY));

            $response = array('status' => 'ok', 'code' => 200, 'notes' => $notes);
        }

        $this->getResponse()->setStatusCode($response['code']);

        return $this->renderText(json_encode($response));
    }

}