<?php

/**
 * lesson actions.
 *
 * @package    kuepa
 * @subpackage lesson
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lessonActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $course_id = $request->getParameter('course_id');
        $this->course = Course::getRepository()->find($course_id);
        
        $chapter_id = $request->getParameter('chapter_id');
        $this->chapter = Chapter::getRepository()->find($chapter_id);

        $lesson_id = $request->getParameter('lesson_id');
        $this->lesson = Lesson::getRepository()->find($lesson_id);
        
        $resource_id = $request->getParameter('resource_id');
        $previous_resource_id = $request->getParameter('previous_resource_id');
        
        if($resource_id != null) {
            $this->resource = Resource::getRepository()->find($resource_id);
        } else if($previous_resource_id != null) {
            $this->resource = $this->lesson->getNextResource($previous_resource_id);
            if($this->resource == null)
                $this->resource = $this->lesson->getChildren()->getFirst();
                $resource_id = $this->resource->getId();
        } else {
            $this->resource = $this->lesson->getChildren()->getFirst();
            $resource_id = $this->resource->getId();
        }
        
        $this->has_next_resource = ($this->lesson->getNextResource($this->resource->getId()) != null);
        
        //set ProfileComponentCompletedStatus
        ProfileComponentCompletedStatusService::getInstance()->add(100, $this->getProfile()->getId(), $this->resource->getId(), $this->lesson->getId(), $this->chapter->getId(), $this->course->getId());
        $this->notes = NoteService::getInstance()->getNotes($this->getProfile()->getId(), $resource_id);
    }

    public function executeCreate(sfWebRequest $request) {
      $form = new LessonForm();
      $values = $request->getParameter($form->getName());
      $response = Array(
          'status' => "error",
          'template' => "",
          'code' => 400
        );

      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      if($form->isValid()){
        //create lesson
        $lesson = $form->save();

        //add lesson to chapter
        ChapterService::getInstance()->addLessonToChapter($values['chapter_id'], $lesson->getId());

        $response['template'] = "Ha creado la lección satisfactoriamente";
        $response['status'] = "success";
      }else{
        $response['template'] = $this->getPartial("form", array('form' => $form));
      }

      if($request->isXmlHttpRequest()) {  
        return $this->renderText( json_encode($response) );
      }
        
      return $this->renderText( $response['template'] );
    }
}
