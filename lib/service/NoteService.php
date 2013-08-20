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

        return $note;
    }
    
    public function deleteNote($note_id){
        $note = Note::getRepository()->find($note_id);
        $note->remove();
    }
    
    public function getNotes($profile_id, $resource_id, $query_params = null) {
        $notes = Note::getRepository()->createQuery('n')
                    ->select('n.content, n.created_at, p.nickname')
                    ->innerJoin('n.Profile p')
                    ->where('profile_id = ? and resource_id = ?', array($profile_id, $resource_id))
                    ->orderBy('id desc');

        if($query_params){
            return $notes->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $notes->execute();
    }
}
