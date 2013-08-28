<?php

class MessagingService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new MessagingService;
        }

        return self::$instance;
    }

    public function sendMessage($profile_id, Array $recipients, $subject, $content) {
        $message = new Message;
        $message->setSubject($subject);
        $message->setMessage($content);
        $message->setAuthorId($profile_id);

        foreach ($recipients as $recipient_id) {
            $recipient = new MessageRecipient;
            $recipient->setRecipientId($recipient_id);

            $message->getRecipients()->add($recipient);
        }

        $message->save();
        
        return $message;
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
}
