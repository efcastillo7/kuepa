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



        //test
        // CourseService::getInstance()->create(array(
        //     'name' => 'pindonga2',
        //     'description' => 'la garchanga2',
        //     'profile_id' => $this->getProfile()->getId(),
        //     'duration' => 144.5
        // ));

        // CourseService::getInstance()->edit(16, array(
        //     'name' => 'pindonga2 edit',
        //     'description' => 'la garchanga',
        //     'profile_id' => $this->getProfile()->getId(),
        //     'duration' => 144.5,
        //     'thumbnail' => 'icon-chemical.png'
        // ));

        // CourseService::getInstance()->delete(15);

        // CourseService::getInstance()->addTeacher(16, 1);
        // CourseService::getInstance()->removeTeacher(16, 1);

        foreach (CourseService::getInstance()->getChaptersLists(7) as $chapter) {
            echo $chapter->getName();
        }
    }
}
