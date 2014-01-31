<?php

class NotificationMessage {
    /**
     * Creates a video session notification
     * @param string $videoSessionId
     * @return boolean
     */
    static public function add($message_id){
        //Gets the video session data
        $message = Message::getRepository()->find($message_id);

        if(!$message){
            return false;
        }

        $author_id = $message->getAuthorId();

        //Persists the notification action
        $notificationAction = new NotificationAction();
        $notificationAction
                ->setProfile($message->getProfile())
                ->setTermKey("new_message")
                ->setRouteName("messages")
                ->setType("message")
                ->setWildcards(json_encode(
                    array(
                        "from"    => $message->getProfile()->getNickname(),
                        "content" => $message->getContent()
                    )
                ))
                ->save();

        //And the notifications for each user
        if($message->getParentId() != null){
            $profiles = $message->getRoot()->getRecipients();
        }else{
            $profiles = $message->getRecipients();
        }
        

        foreach($profiles as $recipient){
            if($recipient->getRecipientId() != $author_id){
                $notification = new Notification();
                $notification
                    ->setNotificationAction($notificationAction)
                    ->setProfileId($recipient->getRecipientId())
                    ->save();
            }
        }
    }

}
