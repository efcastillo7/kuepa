<?php

/**
 * course actions.
 *
 * @package    kuepa
 * @subpackage course
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class learning_pathActions extends kuepaActions {

    /**
     * POST /course
     *
     * @param sfRequest $request A request object
     */
    public function executeCreate(sfWebRequest $request) {
        return $this->renderText('create');
    }

    /**
     * GET /course
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
        return $this->renderText('list');
    }

    /**
     * GET /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        return $this->renderText('get');
    }

    /**
     * PUT /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->update($request);
    }

    /**
     * DELETE /learning_path/{parent_id}/{child_id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        $parent_id = $request->getParameter('parent_id');
        $child_id  = $request->getParameter('child_id');
        
        $status = ComponentService::getInstance()->removeChildFromComponent($parent_id, $child_id);
        
        if($status) {
            return $this->renderText(json_encode(Array('status' => 'success')));
        } else {
            return $this->renderText(json_encode(Array('status' => 'error')));
        }
    }

}
