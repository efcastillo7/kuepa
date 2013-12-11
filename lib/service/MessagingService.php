<?php

class MessagingService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new MessagingService;
        }

        return self::$instance;
    }

    public function replyMessage($profile_id, $message_id, $content){
        //add new message
        $message = new Message;
        $message->setContent($content)
                ->setAuthorId($profile_id)
                ->setParentId($message_id)
                ->save();

        //update read flag as false
        $query = MessageRecipient::getRepository()->createQuery('mr')
                ->update()
                ->set('is_read', 0)
                ->where('mr.recipient_id != ?', $profile_id)
                ->execute();

        return $message;
    }

    public function sendMessage($profile_id, Array $recipients, $subject, $content) {
        $message = new Message;
        $message->setSubject($subject);
        $message->setContent($content);
        $message->setAuthorId($profile_id);

        foreach ($recipients as $recipient_id) {
            $recipient = new MessageRecipient;
            $recipient->setRecipientId($recipient_id);

            $message->getRecipients()->add($recipient);
        }

        //add myself as recipient
        $recipient = new MessageRecipient;
        $recipient->setRecipientId($profile_id);
        $message->getRecipients()->add($recipient);

        //save
        $message->save();
        
        return $message;
    }

    public function getMessagesForUser($profile_id, Array $query_params = null){
        $query = Message::getRepository()->createQuery('m')
                    ->innerJoin("m.Recipients mr")
                    // ->select('subject, content, updated_at')
                    ->where('mr.recipient_id = ?')
                    ->orderBy('m.updated_at desc');

        if($query_params){
            return $query->execute($query_params['params'], $query_params['hydration_mode']);    
        }

        return $query->execute();
    }

    public function listMessageRecipients($profile_id, Array $query_params = null) {
        $query = MessageRecipient::getRepository()->createQuery('mr')
                ->innerJoin('mr.Message m')
                ->where('mr.recipient_id = ?', $profile_id)
                ->orderBy('m.created_at desc');
        
        if($query_params){
            return $query->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $query->execute();
    }
    
    public function getMessageRecipient($profile_id, $message_id, $mark_as_read = true) {
        $query = MessageRecipient::getRepository()->createQuery('mr')
                ->innerJoin('mr.Message m')
                ->where('mr.recipient_id = ?', $profile_id)
                ->addWhere('mr.message_id = ?', $message_id)
                ->orderBy('m.created_at desc');
        
        $message_recipient = $query->fetchOne();
 
        $message_recipient->setIsRead($mark_as_read);
        $message_recipient->save();
        
        return $message_recipient;
    }

    public function getThread($parent_id){
        $q = Message::getRepository()->createQuery('m')
                ->where("(parent_id = ?) or (id = ? and parent_id is null)", array($parent_id, $parent_id))
                ->orderBy("created_at asc");

        return $q->execute();
    }
}
