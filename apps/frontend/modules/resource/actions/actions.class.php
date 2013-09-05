<?php

/**
 * resource actions.
 *
 * @package    kuepa
 * @subpackage resource
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class resourceActions extends sfActions
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

  public function executeCreate(sfWebRequest $request) {
    $form = new ResourceForm();
    $values = $request->getParameter($form->getName());

    $form->bind($values);
    if($form->isValid()){
      //create course
      $resource = $form->save();

      //add lesson to chapter
      LessonService::getInstance()->addResourceToLesson($values['lesson_id'], $resource->getId());

      return $this->renderText("Ha creado el recurso satisfactoriamente");
    }

    return $this->renderText( $this->getPartial("form", array('form' => $form)) );
}
}
