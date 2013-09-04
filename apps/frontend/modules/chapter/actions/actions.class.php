<?php

/**
 * chapter actions.
 *
 * @package    kuepa
 * @subpackage chapter
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class chapterActions extends kuepaActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeExpanded(sfWebRequest $request) {
      $chapter_id = $request->getParameter('chapter_id');
      $course_id = $request->getParameter('course_id');
      
      $this->profile = $this->getProfile();
      
      $this->course = Course::getRepository()->find($course_id);
      $this->chapter = Chapter::getRepository()->find($chapter_id);
      $this->lessons = $this->chapter->getChildren();
      
      if($request->isXmlHttpRequest()) {
          $response = Array(
              'status' => 'success',
              'template' => $this->getPartial('views/navigator/lesson_list')
          );
                  
          return $this->renderText( json_encode($response) );
      }
      
      return $this->renderText( $this->getPartial('views/navigator/lesson_list') );
  }

  public function executeCreate(sfWebRequest $request) {
    $form = new ChapterForm();
    $values = $request->getParameter($form->getName());

    $form->bind($values);
    if($form->isValid()){
      //create course
      $chapter = $form->save();

      //add chapter to course
      CourseService::getInstance()->addChapterToCourse($values['course_id'], $chapter->getId());


      return $this->renderText("Ha creado la unidad satisfactoriamente");
    }

    return $this->renderText( $this->getPartial("form", array('form' => $form)) );
  }
  
}
