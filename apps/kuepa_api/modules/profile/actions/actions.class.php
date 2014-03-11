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
        
        $profile = $this->getUser()->getProfile();
        $messages = array();
        
        foreach ($profile->getFriends() as $friend) {
            
            $message_last = MessagingService::getInstance()->getLastMessagesFromUsers($profile->getId(),$friend->getId());
            $last_message = array();
            if($message_last){
                $last_message = array(
                    'date' =>  date("d/m/Y h:m:s", strtotime($message_last->getUpdatedAt())),
                    'content' => $message_last->getContent(),
                    'id' => $message_last->getParentId(),
                    'created_at' => $message_last->getCreatedAt()
                );
            }
            
            $messages[] = array(
                'id' => $friend->getId(),
                'nickname' => $friend->getNickname(),
                'online' => false,
                'last_message' => $last_message,
            );
        }
        return $this->renderText(json_encode($messages));
	}

	/**
     * GET /profile
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
        $profile =  $this->getUser()->getProfile();

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
