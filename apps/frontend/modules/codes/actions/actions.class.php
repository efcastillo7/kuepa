<?php

/**
 * codes actions.
 *
 * @package    kuepa
 * @subpackage codes
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class codesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->register_codes = Doctrine_Core::getTable('RegisterCode')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->register_code = Doctrine_Core::getTable('RegisterCode')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->register_code);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new RegisterCodeForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new RegisterCodeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($register_code = Doctrine_Core::getTable('RegisterCode')->find(array($request->getParameter('id'))), sprintf('Object register_code does not exist (%s).', $request->getParameter('id')));
    $this->form = new RegisterCodeForm($register_code);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($register_code = Doctrine_Core::getTable('RegisterCode')->find(array($request->getParameter('id'))), sprintf('Object register_code does not exist (%s).', $request->getParameter('id')));
    $this->form = new RegisterCodeForm($register_code);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($register_code = Doctrine_Core::getTable('RegisterCode')->find(array($request->getParameter('id'))), sprintf('Object register_code does not exist (%s).', $request->getParameter('id')));
    $register_code->delete();

    $this->redirect('codes/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $register_code = $form->save();

      $this->redirect('codes/edit?id='.$register_code->getId());
    }
  }
}
