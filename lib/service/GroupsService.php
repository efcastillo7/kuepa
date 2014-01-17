<?php
class GroupsService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new GroupsService;
        }
        
        return self::$instance;
    }
    
    public function find($id){
        return Groups::getRepository()->find($id);
    }

    public function getGroupsByLevel($level = 0){
        /* TODO: all infinite tree in on query
            SELECT gsg.parent_id AS level1, gsg.child_id AS level2, gsg1.child_id AS level3
            FROM  `group_sub_group` gsg
            LEFT JOIN  `group_sub_group` gsg1 ON gsg.child_id = gsg1.parent_id
            LEFT JOIN  `group_sub_group` gsg2 ON gsg1.child_id = gsg2.parent_id
        */
        return(Groups::getRepository()->findByLevel($level));
    }

    public function getChildren($group_id){

        return(self::getInstance()->find($group_id)->getChildren());

    }

    public function save($values = array()) {
      // group
       if( (int)$values['id'] > 0 ) {
         $group = self::getInstance()->find($values['id']);
       }else{
         $group = new Groups();
       }
        
        $group->setName($values['name'])
              ->setDescription($values['description'])
              ->setLevel($values['level'])
              ->setCreatorId($values['creator_id'])
              ->save();
        return $group;
    }

    public function deleteGroup( $group_id ){
        $group = self::getInstance()->find($group_id);
        $children = $group->getChildren();
        if ( count($children) > 0 ){
            foreach ($children as $key => $child) {
                self::deleteGroup($child -> getId() );
            }
        }

        $gp = GroupProfile::getRepository()->createQuery('gp');
        $gp->delete()
           ->andWhere("group_id = ? ", $group->getId() )
           ->execute();
        $gsg = GroupSubGroup::getRepository()->createQuery('gsg');
        $gsg->delete()
           ->andWhere("parent_id = ?", $group->getId() )
           ->orWhere("child_id = ?", $group->getId() )
           ->execute();
        $group -> delete();

    }

    public function addChildToGroup($parent_id, $child_id) {
        $gsg = new GroupSubGroup();
        $gsg->setParentId($parent_id)
            ->setChildId($child_id)
            ->save();
        return($gsg);
    }

    public function getProfilesInGroup($group_id){
        $group = self::getInstance()->find($group_id);
        //$users = Profile::getRepository()->createQuery('p')->execute();
        $users = $group->getProfiles();
        return($users);
    }
        
    public function addProfileToGroup($group_id, $profile_id){
        $gp = new GroupProfile();
        $gp -> setGroupId($group_id);
        $gp -> setProfileId($profile_id);
        $gp->save();
        return($gp);
    }

    public function removeProfileFromGroup($group_id, $profile_id){
        $gp = GroupProfile::getRepository()->find(array($group_id,$profile_id));
        if ( $gp ){
            $gp -> delete();    
        }
        
    } 

    /** Profiile List
    *   filtering the already added profiles in the current group
    */
    public function getProfilesList($group_id, $filters = array() ){
        // Todo : Add $filters andWhere
        /**
        */
        $q = Profile::getRepository()->createQuery('p')
                ->select('p.*')
                ->leftJoin('p.GroupProfile gp ON (gp.group_id ='.$group_id.'  AND p.id=gp.profile_id )')
                ->where('gp.group_id IS NULL');

        return $q->execute();
    }


    public function getParent($group_id){
        $group = self::getInstance()->find($group_id);
        return($group->getParents()->getFirst());
    }


}
