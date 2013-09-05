<?php

/**
 * course actions.
 *
 * @package    kuepa
 * @subpackage course
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends kuepaActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->courses = ComponentService::getInstance()->getCoursesForUser($this->getUser()->getGuardUser()->getProfile()->getId());
  }

  public function executeDetails(sfWebRequest $request){
    $id = $request->getParameter("id");

    $this->profile = $this->getProfile();
    $this->course = Course::getRepository()->find($id);
  }
  
  public function executeExpanded(sfWebRequest $request) {
      $course_id = $request->getParameter('course_id');
      $type = $request->getParameter('type', 'grid');
      
      $this->profile = $this->getProfile();
      
      $this->course = Course::getRepository()->find($course_id);
      $this->chapters = $this->course->getChildren();
      
      if($request->isXmlHttpRequest()) {
          $response = Array(
              'status' => 'success',
              'template' => $this->getPartial($type)
          );
                  
          return $this->renderText( json_encode($response) );
      }
      
      return $this->renderText( $this->getPartial($type) );
  }

  public function executeCreate(sfWebRequest $request) {
    $form = new CourseForm();
    $values = $request->getParameter($form->getName());
    $response = Array(
        'status' => "error",
        'template' => "",
        'code' => 400
    );

    $form->bind($values);
    if($form->isValid()){
      //create course
      $course = $form->save();

      //add to user
      CourseService::getInstance()->addTeacher($course->getId(), $this->getProfile()->getId());

      $response['template'] = "Ha creado el curso satisfactoriamente";
      $response['status'] = "success";
      $response['course_id'] = $course->getId();
    }else{
      $response['template'] = $this->getPartial("form", array('form' => $form));
    }

    if($request->isXmlHttpRequest()) {  
      return $this->renderText( json_encode($response) );
    }
      
    return $this->renderText( $response['template'] );
  }

}
