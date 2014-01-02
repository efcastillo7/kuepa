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
        $previous_lesson_id = $request->getParameter('previous_lesson_id');
        $following_lesson_id = $request->getParameter('following_lesson_id');

        $resource_id = $request->getParameter('resource_id');

        if ($lesson_id != null) {
            $this->lesson = Lesson::getRepository()->find($lesson_id);
            $this->lesson->setActualResource($resource_id);
        } else if ($previous_lesson_id != null) {
            $this->lesson = $this->chapter->getNextChild($previous_lesson_id);
            if ($this->lesson == null)
                $this->lesson = $this->chapter->getChildren()->getFirst();
            $lesson_id = $this->lesson->getId();
        } else if ($following_lesson_id != null) {
            $this->lesson = $this->chapter->getPreviousChild($following_lesson_id);
            if ($this->lesson == null)
                $this->lesson = $this->chapter->getChildren()->getFirst();
            $lesson_id = $this->lesson->getId();
        } else {
            $this->lesson = $this->chapter->getChildren()->getFirst();
            $lesson_id = $this->lesson->getId();
        }

        $this->has_next_lesson = ($this->chapter->getNextChild($this->lesson->getId()) != null);
        $this->has_previous_lesson = ($this->chapter->getPreviousChild($this->lesson->getId()) != null);

        $this->resource = Resource::getRepository()->find($this->lesson->getActualResourceId());

        $this->has_next_resource = ($this->lesson->getNextResourceId() != null);
        $this->has_previous_resource = ($this->lesson->getPreviousResourceId() != null);

        $this->is_last_resource = $this->lesson->atLastResource();
        $this->is_first_resource = $this->lesson->atFirstResource();

        //test
        ComponentService::getInstance()->updateDuration($this->resource->getId());

        //update log
        LogService::getInstance()->viewResource(Resource::TYPE, $this->lesson->getActualResourceId(), $this->getUser()->getProfile()->getId());

        //set ProfileComponentCompletedStatus
        ProfileComponentCompletedStatusService::getInstance()->add(100, $this->getProfile()->getId(), $this->resource->getId(), $this->lesson->getId(), $this->chapter->getId(), $this->course->getId());
        $this->notes = NoteService::getInstance()->getNotes($this->getProfile()->getId(), $resource_id);
        $this->comments = NoteService::getInstance()->getComments($resource_id);
    }

    public function executeCreate(sfWebRequest $request) {
        $id = $request->getParameter("id");

        if ($id) {
            $form = new LessonForm(Lesson::getRepository()->find($id));
        } else {
            $form = new LessonForm();
        }

        $values = $request->getParameter($form->getName());
        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            //create lesson
            $lesson = $form->save();

            //add lesson to chapter
            if (!$id)
                ChapterService::getInstance()->addLessonToChapter($values['chapter_id'], $lesson->getId());

            ComponentService::getInstance()->updateDuration( $lesson->getId() );

            $response['template'] = "Ha " . ($id ? "editado" : "creado") . " la lección satisfactoriamente";
            $response['status'] = "success";
        } else {
            $response['template'] = $this->getPartial("form", array('form' => $form));
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

}
