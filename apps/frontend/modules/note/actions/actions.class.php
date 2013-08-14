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

}