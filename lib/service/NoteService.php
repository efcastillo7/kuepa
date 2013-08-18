<?php

class NoteService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new NoteService;
        }
        
        return self::$instance;
    }
    
    public function createNote($profile_id, $resource_id, $content) {
        $note = new Note;
        $note->setProfileId($profile_id);
        $note->setResourceId($resource_id);
        $note->setContent($content);
        $note->save();
    }
    
    public function deleteNote($note_id){
        $note = Note::getRepository()->find($note_id);
        $note->remove();
    }
    
    public function getNotes($profile_id, $resource_id) {
        $notes = Note::getRepository()->findByProfileIdAndResourceId($profile_id, $resource_id);
        
        return $notes;
    }
}
