<?php

/**
 * message actions.
 *
 * @package    kuepa
 * @subpackage message
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class messageActions extends sfActions
{
 	/**
	 * POST /message
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeCreate(sfWebRequest $request) {
		$profile_id = $this->getUser()->getProfile()->getId();

		$recipients = $request->getPostParameter("recipients");
		$subject = $request->getPostParameter("subject");
		$content = $request->getPostParameter("content");
		$parent_id = $request->getPostParameter("thread_id");

        if($content != ""){
            $message = MessagingService::getInstance()->sendMessage($profile_id, $recipients, $subject, $content);

            $response = array(
                'id' => $message->getId(),
                'subject' => $message->getSubject(),
                'content' => $message->getContent(),
                'author' => $message->getProfile()->getNickname(),
                'date' => $message->getCreatedAt(),
                'in' => $message->getAuthorId() == $profile_id ? false : true
            );
        }

        return $this->renderText(json_encode($response));
	}

	/**
     * GET /message
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
    	$profile_id = $this->getUser()->getProfile()->getId();

        $messages = MessagingService::getInstance()->getMessagesForUser($profile_id);

        //TODO: check for valid parameters

        $response = array();
        foreach($messages as $message){
            $recipients = array();
            foreach($message->getRecipients() as $recipient){
                if($recipient->getRecipientId() != $profile_id){
                    $recipients[] = $recipient->getRecipient()->getNickname();
                }
            }

        	$response[] = array(
        		'id' => $message->getId(),
        		'subject' => $message->getSubject(),
        		'content' => $message->getContent(),
        		'author' => $message->getProfile()->getNickname(),
                'recipients' => $recipients,
                'date' => $message->getCreatedAt(),
        		'last_update' => $message->getUpdatedAt(),
    		);
        }

        return $this->renderText(json_encode($response));
    }

    /**
     * GET /message/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        $thread_id = $request->getParameter("id");
        $profile_id = $this->getUser()->getProfile()->getId();
        $from_time = $request->getParameter("from_time", null);

        //TODO: check for valid parameters

        $messages = MessagingService::getInstance()->getThread($thread_id, $from_time);
        $response = array();

        foreach($messages as $message){
        	$response[] = array(
        		'id' => $message->getId(),
        		'subject' => $message->getSubject(),
        		'content' => $message->getContent(),
        		'author' => $message->getProfile()->getNickname(),
        		'date' => $message->getCreatedAt(),
                'created_at' => strtotime($message->getCreatedAt()),
                'in' => $message->getAuthorId() == $profile_id ? false : true
    		);
        }

        return $this->renderText(json_encode($response));
    }

    /**
     * POST /message/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeAdd(sfWebRequest $request) {
    	$profile_id = $this->getUser()->getProfile()->getId();

    	//TODO: check for valid parameters

		$content = $request->getParameter("content");
		$parent_id = $request->getParameter("id");
        $response = null;

        if($content != ""){
            $message = MessagingService::getInstance()->replyMessage($profile_id, $parent_id, $content);

            $response = array(
                'id' => $message->getId(),
                'subject' => $message->getSubject(),
                'content' => $message->getContent(),
                'author' => $message->getProfile()->getNickname(),
                'date' => $message->getCreatedAt(),
                'in' => $message->getAuthorId() == $profile_id ? false : true
            );
        }

        return $this->renderText(json_encode($response));
    }

    /**
     * PUT /message/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->renderText('edit');
    }

    /**
     * DELETE /message/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        $profile_id = $this->getUser()->getProfile()->getId();
        $message_id = $request->getParameter("id");
        $recipients = array($profile_id);

        //remove!
        MessagingService::getInstance()->removeRecipients($message_id, $recipients);

        return $this->renderText(json_encode("Success"));
    }


}
