<?php

class MessagingService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new MessagingService;
        }

        return self::$instance;
    }
    
    public function getLastMessagesFromUsers($remitente_id, $destinatario_id){
        $query = Message::getRepository()->createQuery('m')
                    ->innerJoin("m.Recipients mr ON  m.parent_id = mr.message_id ")
                    ->where("mr.recipient_id = ?", $destinatario_id)
                    ->addWhere("m.author_id = ?", $remitente_id)
                    ->orWhere("mr.recipient_id = ?", $remitente_id)
                    ->addWhere("m.author_id = ?", $destinatario_id)
                    ->orderBy("m.updated_at desc");
        return $query->fetchOne();
    }
    
    public function getMessagesFromUsers(Array $profile_ids){
        $query = Message::getRepository()->createQuery('m')
                    ->innerJoin("m.Recipients mr")
                    ->where("mr.recipient_id = ?", $profile_ids[0])
                    ->andWhere('m.parent_id is null')
                    ->andWhere('EXISTS (SELECT * FROM MessageRecipient mr2 WHERE mr2.message_id = m.id AND mr2.recipient_id = ?)', $profile_ids[1])
                    ->orderBy("mr.is_read desc, m.updated_at asc");

        return $query->execute();
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
                ->andWhere('mr.message_id = ?', $message_id)
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

    public function addRecipients($message_id, Array $recipients){
        $message = Message::getRepository()->find($message_id);

        foreach ($recipients as $recipient_id) {
            $recipient = new MessageRecipient;
            $recipient->setRecipientId($recipient_id);

            $message->getRecipients()->add($recipient);
        }

        $message->save();

        return $message;
    }

    public function removeRecipients($message_id, Array $recipients){
        // $message = Message::getRepository()->find($message_id);

        $q = MessageRecipient::getRepository()->createQuery()->delete()
            ->where("message_id = ?", $message_id)
            ->andWhereIn("recipient_id", $recipients);

        return $q->execute();
    }

    public function getMessagesForUser($profile_id, Array $query_params = null){
        $query = Message::getRepository()->createQuery('m')
                    // ->innerJoin("m.Recipients mr")
                    ->innerJoin("m.Profile p")
                    // ->select('subject, content, p.nickname, updated_at, parent_id')
                    ->where('m.id in (select message_id from message_recipient where recipient_id = ?)')
                    ->orderBy('m.updated_at asc');

        if($query_params){
            return $query->execute($query_params['params'], $query_params['hydration_mode']);    
        }

        return $query->execute($profile_id);
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

    public function getUnreadMessages($profile_id){
        
        $query = Message::getRepository()->createQuery('m')
                ->innerJoin('m.Recipients mr ON  m.parent_id = mr.message_id')
                ->where('mr.recipient_id = ?', $profile_id)
                ->addWhere('mr.is_read = 0')
                ->orderBy('m.updated_at desc');
        
        return $query->fetchOne();
    }

    public function markMessageAsRead($profile_id, $message_id, $read = true){
        //update flag
        MessageRecipient::getRepository()->createQuery('mr')
            ->update()
            ->set('is_read', $read)
            ->where('message_id = ?', $message_id)
            ->andWhere('recipient_id = ?', $profile_id)
            ->execute();

        return;
    }

    public function getThread($thread_id, $from_time = null){
        //get messages
        $q = Message::getRepository()->createQuery('m')
                ->where("(parent_id = ?) or (id = ? and parent_id is null)", array($thread_id, $thread_id))
                ->orderBy("created_at asc");

        if($from_time){
            $q->andWhere("created_at > ?", Date("Y-m-d H:i:s",$from_time));
        }

        return $q->execute();
    }
}
