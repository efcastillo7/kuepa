<?php

/**
 * profile actions.
 *
 * @package    kuepa
 * @subpackage profile
 * @author     Pablo A.
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions
{
	/**
     * POST /profile
     *
     * @param sfRequest $request A request object
     */
	public function executeCreate(sfWebRequest $request) {
		return $this->renderText(json_encode("Success"));
	} 

	/**
     * GET /profile/friends
     *
     * @param sfRequest $request A request object
     */
	public function executeContacts(sfWebRequest $request) {
		$profile_id = $this->getUser()->getProfile()->getId();
        $profile = Profile::getRepository()->find($profile_id);

		$without_messages = array();
        $with_messages = array();
        foreach ($profile->getFriends() as $friend) {
        	$messages_q = MessagingService::getInstance()->getMessagesFromUsers(array($profile_id,$friend->getId()));
        	$i = $messages_q->count();
        	$last_message = array();
            $new_messages = false;

        	if($i){
        		$last_message = array(
        			'date' => $messages_q[0]->getUpdatedAt(),
        			'content' => $messages_q[0]->getContent(),
        			'id' => $messages_q[0]->getId()
    			);

                $new_messages = !$messages_q[0]->getRecipients()->getFirst()->getIsRead();
        	}

            if($new_messages){
                $with_messages[] = array(
                    'id' => $friend->getId(),
                    'first_name' => $friend->getFirstName(),
                    'last_name' => $friend->getLastName(),
                    'nickname' => $friend->getNickname(),
                    'avatar' => '/uploads/avatars' . $friend->getAvatar(),
                    'online' => false,
                    'last_message' => $last_message,
                    'new_messages' => $new_messages
                );
            }else{
            	$without_messages[] = array(
            		'id' => $friend->getId(),
            		'first_name' => $friend->getFirstName(),
            		'last_name' => $friend->getLastName(),
            		'nickname' => $friend->getNickname(),
                    'avatar' => '/uploads/avatars' . $friend->getAvatar(),
            		'online' => false,
            		'last_message' => $last_message,
                    'new_messages' => $new_messages
        		);
            }



        }

        return $this->renderText(json_encode(array_merge($with_messages, $without_messages)));
	}

	/**
     * GET /profile
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
    	$profile_id = $this->getUser()->getProfile()->getId();
        $profile = Profile::getRepository()->find($profile_id);

        //TODO
        if(!$profile){
        	return "error";
        }

        $response = array(
        	'first_name' => $profile->getFirstName(),
        	'last_name' => $profile->getLastName(),
        	'nickname' => $profile->getNickname(),
        	'birthdate' => $profile->getBirthdate(),
    	);

        return $this->renderText(json_encode($response));
    }

    /**
     * GET /profile/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {

    }

    /**
     * POST /profile/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeAdd(sfWebRequest $request) {
    	

        return $this->renderText(json_encode($response));
    }

    /**
     * PUT /profile/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->renderText('edit');
    }

    /**
     * DELETE /profile/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        

        return $this->renderText(json_encode("Success"));
    }
}
