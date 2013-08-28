<?php

/**
 * messaging actions.
 *
 * @package    kuepa
 * @subpackage lesson
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class messagingActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $message = MessagingService::getInstance()->sendMessage($this->getProfile()->getId(), Array(1, 2), 'test subject', 'test content');
        $message = MessagingService::getInstance()->getMessageRecipient($this->getProfile()->getId(), $message->getId());
        
        $messages= MessagingService::getInstance()->listMessageRecipients($this->getProfile()->getId());
        
        var_dump($messages->toArray());
    }
}
