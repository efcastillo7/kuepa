<?php

/**
 * lesson actions.
 *
 * @package    kuepa
 * @subpackage lesson
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lessonActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $lesson_id = $request->getParameter('lesson_id');
        $this->lesson = Lesson::getRepository()->find($lesson_id);
        
        $chapter_id = $request->getParameter('chapter_id');
        $this->chapter = Chapter::getRepository()->find($chapter_id);
        
        $course_id = $request->getParameter('course_id');
        $this->course = Course::getRepository()->find($course_id);
        
        $resource_id = $request->getParameter('resource_id');
        $this->resource = ($resource_id == null ? $this->lesson->getChildren()->getFirst() : Resource::getRepository()->find($resource_id));
    }

}
