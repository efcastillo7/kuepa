<?php

class MessagingService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new MessagingService;
        }
        
        return self::$instance;
    }
    
    public function sendMessage($profile_id, Array $recipients, $subject, $body) {
        
    }
    
    public function listMessages($profile_id, Array $parameters = null) {
        
    }
}
