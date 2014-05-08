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

        $friends = $profile->getFriends();

        $friends_ids = $friends->getPrimaryKeys();
        //TODO: OPTIMIZE!

        foreach ($friends as $friend) {
            $message_last = MessagingService::getInstance()->getLastMessageFromUser($profile->getId(),$friend->getId());
            $last_message = array();
            if($message_last){
                $last_message = array(
                    'date' =>  date("d/m/Y h:m:s", strtotime($message_last->getUpdatedAt())),
                    'content' => $message_last->getContent(),
                    'id' => $message_last->getParentId() ? $message_last->getParentId() : $message_last->getId(),
                    'created_at' => $message_last->getCreatedAt()
                );
            }
            
            $messages[] = array(
                'id' => $friend->getId(),
                'nickname' => $friend->getNickname(),
                'firstname' => $friend->getFirstName(),
                'lastname' => $friend->getLastName(),
                'role' => $friend->getSfGuardUser()->getSfGuardUserGroup()->getFirst()->getGroup()->getDescription(),
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
    	$id = $request->getParameter("id");
        $data = $request->getParameter("profile");
        $reponse_status = false;

        $profile = $this->getUser()->getProfile();

        //TODO: check if is user for direct changes
        //if not directive then avoid id

        if(isset($data['phone']) && !empty($data['phone'])){
            $profile->setPhone($data['phone']);
            $reponse_status = true;
        }

        if(isset($data['celphone']) && !empty($data['celphone'])){
            $profile->setMobilePhone($data['celphone']);
            $reponse_status = true;
        }

        $profile->save();

        $response = array('status' => "ok");

        if(!$reponse_status){
            $this->getResponse()->setStatusCode(406);
            $response = 'Campos Invalidos';
        }


        return $this->renderText(json_encode($response));
    }

    public function executeFlashmessage(sfWebRequest $request) {
        //check if post
        $this->forward404Unless($request->isMethod('POST'));

        $id = $request->getParameter('id');
        $profile = $this->getUser()->getProfile();

        FlashMessageService::getInstance()->setMessagesAsViewed($profile->getId(), $id);

        return $this->renderText(json_encode(array('status' => 'ok')));
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
