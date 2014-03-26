<?php

/**
 * user actions.
 *
 * @package    kuepa
 * @subpackage user
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->user = $this->getUser();
        $this->form = new UserProfileForm($this->getProfile());
        
        //$this->getUser()->setCulture('');
        //$this->getUser()->getAttributeHolder()->clear();
        //die("AVER:".$this->getUser()->getCulture());

        $this->setLayout("layout_v2");
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->form = new UserProfileForm($this->getProfile());
        $this->processForm($request, $this->form);

        $this->setTemplate('index');
        $this->setLayout("layout_v2");
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $profile = $form->save();

            //reset culture
            $this->getUser()->resetCulture();

            $this->redirect('user/index');
        }
    }

}
