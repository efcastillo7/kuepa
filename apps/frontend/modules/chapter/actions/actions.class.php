<?php

/**
 * chapter actions.
 *
 * @package    kuepa
 * @subpackage chapter
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class chapterActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->forward('default', 'module');
    }

    public function executeExpanded(sfWebRequest $request) {
        $chapter_id = $request->getParameter('chapter_id');
        $course_id = $request->getParameter('course_id');

        $this->profile = $this->getProfile();

        $this->course = Course::getRepository()->find($course_id);
        $this->chapter = Chapter::getRepository()->find($chapter_id);
        $this->lessons = $this->chapter->getChildren();

        if ($request->isXmlHttpRequest()) {
            $response = Array(
                'status' => 'success',
                'template' => $this->getPartial('views/navigator/lesson_list')
            );

            return $this->renderText(json_encode($response));
        }

        return $this->renderText($this->getPartial('views/navigator/lesson_list'));
    }

    public function executeExpanded2(sfWebRequest $request) {
        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');

        $this->profile = $this->getProfile();

        $this->course = Course::getRepository()->find($course_id);
        $this->chapter = Chapter::getRepository()->find($chapter_id);
        $this->lesson = Lesson::getRepository()->find($lesson_id);

        if ($request->isXmlHttpRequest()) {
            $response = Array(
                'status' => 'success',
                'template' => $this->getPartial('lesson/menu_chapters')
            );

            return $this->renderText(json_encode($response));
        }

        return $this->renderText($this->getPartial('lesson/menu_chapters'));
    }

    public function executeCreate(sfWebRequest $request) {
        $id = $request->getParameter("id");

        if ($id) {
            $form = new ChapterForm(Chapter::getRepository()->find($id));
        } else {
            $form = new ChapterForm();
        }

        $values = $request->getParameter($form->getName());
        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            //create course
            $chapter = $form->save();

            //add chapter to course
            if(!$id)
                CourseService::getInstance()->addChapterToCourse($values['course_id'], $chapter->getId());

            ComponentService::getInstance()->updateDuration( $chapter->getId() );

            $response['template'] = "Ha ".($id?"editado":"creado")." la unidad satisfactoriamente";
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
