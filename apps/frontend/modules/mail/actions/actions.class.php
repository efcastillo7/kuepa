<?php

/**
 * mail actions.
 *
 * @package    kuepa
 * @subpackage mail
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->mails = MailService::getInstance()->findAll();
  }

  public function executeNew(sfWebRequest $request){
    $this->mail = new MailMessage;
    if ( $request->isXmlHttpRequest() ){
      $html_content = $this->getPartial('form', array('mail' => $this->mail));
      $response = array(
        'status' => "ok",
        'template' => $html_content,
        'code' => 200);
      return( $this->renderText(json_encode($response) ) );
    }

  }

  public function executeEdit(sfWebRequest $request){
    $id = $request->getParameter('id');
    $this->mail = MailService::getInstance()->find($id);
    if ( $request->isXmlHttpRequest() ){
      $html_content = $this->getPartial('form', array('mail' => $this->mail));
      $response = array(
        'status' => "ok",
        'template' => $html_content,
        'code' => 200,
        'mail_content' => $this->mail->getContent() );
      return( $this->renderText(json_encode($response) ) );
    }
  }

  public function executeCreate(sfWebRequest $request){
    $form = $request->getParameter('mail');
    MailService::getInstance()->save($form);
    //MailService::getInstance()->sendNow($form['email'], $form['subject'], $form['content'], $form['name']);
    $this->redirect('mail/index');
  }

  public function executeDelete(sfWebRequest $request){
    $id = $request->getParameter('id');
    MailService::getInstance()->delete($id);
    $this->redirect('mail/index');
  }

  public function executeSend(sfWebRequest $request){
    $id = $request->getParameter('id');
    MailService::getInstance()->sendMail($id);
    $this->redirect('mail/index');
  }

  public function executePreview(sfWebRequest $request){
    $id = $request->getParameter('id');
    $this -> mail_message = MailService::getInstance()->find($id);
    $this->setLayout(false);
  }

}
