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
      $response = Array(
          'status' => "error",
          'template' => "",
          'code' => 400
        );

      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
      
      if($form->isValid()){
        //create lesson
        $resource = $form->save();

        //add lesson to chapter
        LessonService::getInstance()->addResourceToLesson($values['lesson_id'], $resource->getId());

        //send recurse data form
        switch ($values['recurse_type']) {
          case 'recurse_data_text':
            $resourceData = new ResourceDataText();
            $resourceData->setResourceId($resource->getId());
            $form = new ResourceDataTextForm($resourceData);
            break;

          case 'recurse_data_document':
            $resourceData = new ResourceDataDocument();
            $resourceData->setResourceId($resource->getId());
            $form = new ResourceDataDocumentForm($resourceData);
            break;

          case 'recurse_data_video':
            $resourceData = new ResourceDataVideo();
            $resourceData->setResourceId($resource->getId());
            $form = new ResourceDataVideoForm($resourceData);
            break;
          
          default:
            $resourceData = new ResourceDataText(); 
            $resourceData->setResourceId($resource->getId());
            $form = new ResourceDataTextForm($resourceData);
            break;
        }

        $response['template'] = $this->getPartial("form_recurse", array('form' => $form, 'type' => $values['recurse_type']));
        $response['status'] = "success";
      }else{
        $response['template'] = $this->getPartial("form", array('form' => $form));
      }

      if($request->isXmlHttpRequest()) {  
        return $this->renderText( json_encode($response) );
      }
        
      return $this->renderText( $response['template'] );
  }

  public function executeCreatedata(sfWebRequest $request) {
    $type = $request->getParameter("type");

    switch ($type) {
        case 'recurse_data_text':
          $form = new ResourceDataTextForm();
          break;

        case 'recurse_data_document':
          $form = new ResourceDataDocumentForm();
          break;

        case 'recurse_data_video':
          $form = new ResourceDataVideoForm();
          break;
        
        default:
          $form = new ResourceDataTextForm();
          break;
      }

      $values = $request->getParameter($form->getName());
      $response = Array(
          'status' => "error",
          'template' => "",
          'code' => 400
      );

      $form->bind($values);
      if($form->isValid()){
        //create lesson
        $resourceData = $form->save();

        $response['template'] = "Ok";
        $response['status'] = "success";
        $response['refresh'] = true;
      }else{
        $response['template'] = $this->getPartial("form_recurse", array('form' => $form, 'type' => $type));
      }

      if($request->isXmlHttpRequest()) {  
        return $this->renderText( json_encode($response) );
      }
        
      return $this->renderText( $response['template'] );
  }
}
