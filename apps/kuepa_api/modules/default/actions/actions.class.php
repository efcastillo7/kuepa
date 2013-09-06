<?php

/**
 * default actions.
 *
 * @package    kuepa
 * @subpackage default
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeNotImplemented(sfWebRequest $request) {
        $this->getResponse()->setStatusCode(501);

        return $this->renderText(json_encode(Array('status' => 'error', 'message' => '501 Not Implemented')));
    }
    
    public function executeUnauthorized(sfWebRequest $request) {
        $this->getResponse()->setStatusCode(401);

        return $this->renderText(json_encode(Array('status' => 'error', 'message' => '401 Unauthorized')));
    }
    
    public function executeForbidden(sfWebRequest $request) {
        $this->getResponse()->setStatusCode(403);

        return $this->renderText(json_encode(Array('status' => 'error', 'message' => '403 Forbidden')));
    }

}
