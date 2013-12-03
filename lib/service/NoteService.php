<?php

class NoteService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new NoteService;
        }
        
        return self::$instance;
    }
    
    public function createNote($values = array()) {  
        $note = new Note;
        $note->setProfileId( $values['profile_id'] );
        $note->setResourceId( $values['resource_id'] );
        $note->setContent( $values['content'] );
        $note->setPrivacy( $values['privacy'] );
        $note->save();
        return $note;
    }
    
    public function editNote($profile_id, $new_content, $note_id) {        
        $note = Note::getRepository()->createQuery("n")
                ->where("id = ?", $note_id)
                ->andWhere("profile_id = ?", $profile_id)
                ->fetchOne();
        
        if( $note ) {
            $note->setContent($new_content);
            $note->save();
        }
        
        return $note;
    }
    
    public function deleteNote($note_id, $profile_id){
        $note = Note::getRepository()->createQuery("n")
                ->where("id = ?", $note_id)
                ->andWhere("profile_id = ?", $profile_id)
                ->fetchOne();
        
        if( $note ) {
            $note->delete();
            return true;
        }
        return false;
    }
    
    public function getNotes($profile_id, $resource_id, $query_params = null) {
        $notes = Note::getRepository()->createQuery('n')
                    ->select('n.content, n.created_at, p.nickname')
                    ->innerJoin('n.Profile p')
                    ->where('profile_id = ? and resource_id = ? and privacy = "private" ', array($profile_id, $resource_id))
                    ->orderBy('id desc');

        if($query_params){
            return $notes->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $notes->execute();
    }

    /**
    * getComments
    * @resource_id
    */
    public function getComments($resource_id, $query_params = null) {
        $notes = Note::getRepository()->createQuery('n')
                    ->select('n.content, n.created_at, p.nickname')
                    ->innerJoin('n.Profile p')
                    ->where('resource_id = ? and privacy = "public" ', array($resource_id))
                    ->orderBy('id desc');

        if($query_params){
            return $notes->execute($query_params['params'], $query_params['hydration_mode']);    
        }
        
        return $notes->execute();
    }
}
