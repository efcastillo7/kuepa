<?php

/**
 * chapter actions.
 *
 * @package    kuepa
 * @subpackage chapter
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->profile = $this->getProfile();
        $this->courses = ComponentService::getInstance()->getCoursesForUser($this->getProfile()->getId());
        
        $view_type = $request->getParameter("type");
        
        switch ($view_type) {
            case "list":
                $this->setTemplate("indexlist");
                break;
            case "grid":
            default:
                $this->setTemplate("indexgrid");
                break;
        }
    }
}
