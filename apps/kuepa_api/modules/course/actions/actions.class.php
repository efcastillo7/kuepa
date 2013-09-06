<?php

/**
 * course actions.
 *
 * @package    kuepa
 * @subpackage course
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends sfActions {

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
     * @description Validation is done at the routing level. See routing.yml
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        try {
            $course = Course::getRepository()->find($request->getParameter('id'));
            
            if(!$course) {
                throw new ComponentNotFound;
            }
            
            return $this->renderText(json_encode($course->toArray()));
            
        } catch(ComponentNotFound $e){
            $this->getResponse()->setStatusCode(404);
            
            return $this->renderText(json_encode(Array('status' => 'error')));
        } catch(Exception $e){
            $this->getResponse()->setStatusCode(500);
            
            return $this->renderText(json_encode(Array('status' => 'error')));
        }
    }
    
    /**
     * PUT /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->renderText('edit');
    }
    
    /**
     * DELETE /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        return $this->renderText('delete');
    }

}
