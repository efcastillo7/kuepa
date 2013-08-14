<?php

class NoteService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new NoteService;
        }
        
        return self::$instance;
    }
    
    public function createNote($profile_id, $component_id, $content) {
        $note = new Note;
        $note->setProfileId($profile_id);
        $note->setComponentId($component_id);
        $note->setContent($content);
        $note->save();
    }
    
    public function deleteNote($note_id){
        $note = Note::getRepository()->find($note_id);
        $note->remove();
    }
    
    public function getNotes($profile_id, $component_id) {
        $notes = Note::getRepository()->findByProfileIdAndComponentId($profile_id, $component_id);
        
        return $notes;
    }
}
