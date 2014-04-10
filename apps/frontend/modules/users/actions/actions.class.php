<?php

/**
 * users actions.
 *
 * @package    kuepa
 * @subpackage users
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usersActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->sf_guard_users = Doctrine_Core::getTable('sfGuardUser')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new sfUserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new sfUserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {

    
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfUserForm($sf_guard_user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfUserForm($sf_guard_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $sf_guard_user->delete();

    $this->redirect('users/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user = $form->save();

      $this->redirect('profile/edit?id='.$sf_guard_user->getProfile()->getId());
    }
  }

  public function executeCreateMultiple(sfWebRequest $request){
    $kind = $request->getParameter("kind");
    if ( $kind == "")
      $kind = "estudiante";
    $this->kind = $kind;
    $this->colleges = College::getRepository()->findAll();
    $this->groups = Doctrine_Core::getTable('sfGuardGroup')->findAll();
    $this->message = '';
    if ( $request->isMethod(sfRequest::POST) ){
      $form  = $request->getParameter('form');
      $file = $_FILES['import_file']['tmp_name'];
      $response = ProfileService::getInstance() -> importFromFile($file, $form);
      $this->message = $response['message'];
      $this->getUser()->setAttribute('success', $response['success']);
      $this->getUser()->setAttribute('errors', $response['errors']);
      // echo var_dump($response);
    }



  }

  public function executeDownloadImportFileExample(){

     $module_path = sfContext::getInstance()->getModuleDirectory().'/templates/';
     $file_path = $module_path.'example.csv'; 
     $this->getResponse()->clearHttpHeaders();
     $this->getResponse()->setHttpHeader('Pragma: public', true);
     $this->getResponse()->setContentType('octet/stream');
     $this->getResponse()->setHttpHeader('Content-Disposition',
                            'attachment; filename=example.csv');
     $this->getResponse()->sendHttpHeaders();
     $this->getResponse()->setContent(readfile($file_path));
     return sfView::NONE;
  }

  public function executeViewExportResults(){
    $data = "";
    $success = $this->getUser()->getAttribute('success');
    $errors = $this->getUser()->getAttribute('errors');
    if ( count( $errors ) > 0 ){
      $header="Errores \t";
      $data = $header."\n";
      $data .= implode("\n",  $errors);
      $data .= "\n\n\n";
    }
  
    $header="Usuarios Almacenados \t\n";
    $header.="Nombres\tApellidos\tEmail\tNombre Usuario\tPassword\t";
    $data .= $header."\n";
    foreach ( $success as $key => $user){
      $data .= implode("\t", $user)."\n";
    }

    $this->getResponse()->clearHttpHeaders();
    $this->getResponse()->setHttpHeader("Pragma", "no-cache");
    $this->getResponse()->setContentType('x-msdownload');
    $this->getResponse()->setHttpHeader('Content-Disposition',
                          'attachment; filename=import_results.xls');
    $this->getResponse()->sendHttpHeaders();
    $this->getResponse()->setContent($data);

    //$this->getUser()->getAttributeHolder()->remove('array_ok');
    //$this->getUser()->getAttributeHolder()->remove('array_errors');

    return sfView::NONE;

  }


}
