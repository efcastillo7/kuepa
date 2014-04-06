<?php

/**
 * profile actions.
 *
 * @package    kuepa
 * @subpackage profile
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions
{
  public function executeGetCourses(sfWebRequest $request){
    $id = $request->getParameter("course_id");

    $form = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'expanded' => true, 'model' => 'Component', 'query' => CourseTable::getInstance()->getCoursesForCollegeQuery($id)));

    return $this->renderText($form->render("profile[components_list]"));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->profiles = Doctrine_Core::getTable('profile')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new sfProfileCollegeForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new sfProfileCollegeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($profile = Doctrine_Core::getTable('profile')->find(array($request->getParameter('id'))), sprintf('Object profile does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfProfileCollegeForm($profile);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($profile = Doctrine_Core::getTable('profile')->find(array($request->getParameter('id'))), sprintf('Object profile does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfProfileCollegeForm($profile);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($profile = Doctrine_Core::getTable('profile')->find(array($request->getParameter('id'))), sprintf('Object profile does not exist (%s).', $request->getParameter('id')));
    $profile->delete();

    $this->redirect('profile/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $profile = $form->save();

      $this->redirect('profile/edit?id='.$profile->getId());
    }
  }
}
