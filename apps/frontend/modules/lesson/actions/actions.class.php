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

        if ($lesson_id != null) {
            $this->lesson = Lesson::getRepository()->find($lesson_id);
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

        $resource_id = $request->getParameter('resource_id');
        $previous_resource_id = $request->getParameter('previous_resource_id');
        $following_resource_id = $request->getParameter('following_resource_id');

        if ($resource_id != null) {
            $this->resource = Resource::getRepository()->find($resource_id);
        } else if ($previous_resource_id != null) {
            $this->resource = $this->lesson->getNextChild($previous_resource_id);
            if ($this->resource == null)
                $this->resource = $this->lesson->getChildren()->getFirst();
            $resource_id = $this->resource->getId();
        } else if ($following_resource_id != null) {
            $this->resource = $this->lesson->getPreviousChild($following_resource_id);
            if ($this->resource == null)
                $this->resource = $this->lesson->getChildren()->getFirst();
            $resource_id = $this->resource->getId();
        } else {
            $this->resource = $this->lesson->getChildren()->getFirst();
            $resource_id = $this->resource->getId();
        }

        $this->has_next_resource = ($this->lesson->getNextChild($this->resource->getId()) != null);
        $this->has_previous_resource = ($this->lesson->getPreviousChild($this->resource->getId()) != null);

        //set ProfileComponentCompletedStatus
        ProfileComponentCompletedStatusService::getInstance()->add(100, $this->getProfile()->getId(), $this->resource->getId(), $this->lesson->getId(), $this->chapter->getId(), $this->course->getId());
        $this->notes = NoteService::getInstance()->getNotes($this->getProfile()->getId(), $resource_id);
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
