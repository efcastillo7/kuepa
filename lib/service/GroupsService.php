<?php
class GroupsService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new GroupsService;
        }
        
        return self::$instance;
    }

    public function getCategories($profile_id){
        $q = GroupCategory::getRepository()->createQuery('gc')
                ->innerJoin("gc.Groups g")
                ->innerJoin('g.ProfileHasGroup gp')
                ->where('gp.profile_id = ?',$profile_id);

        return $q->execute();
    }
    
    public function find($id){
        return Groups::getRepository()->find($id);
    }

    public function getByNameAndAuthor($name, $author_id){
        return Groups::getRepository()->createQuery('g')
                    ->where('name like ? and creator_id = ?', array($name, $author_id))
                    ->fetchOne();
    }

    public function getGroupsByAuthor($profile_id, $levels = null){
        $q = Groups::getRepository()->createQuery('g')
                ->where('creator_id = ?',$profile_id);

        if(is_array($levels)){
            $q->andWhereIn('level', $levels);
        }else if($levels){
            $q->andWhere('level = ?', $levels);
        }

        return $q->execute();
    }

    public function getGroupsByProfile($profile_id, $levels = null){
        $q = Groups::getRepository()->createQuery('g')
                ->innerJoin('g.ProfileHasGroup gp')
                ->where('gp.profile_id = ?',$profile_id);

        if(is_array($levels)){
            $q->andWhereIn('level', $levels);
        }else if($levels){
            $q->andWhere('level = ?', $levels);
        }

        return $q->execute();
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
       if( isset($values['id']) && (int)$values['id'] > 0 ) {
         $group = self::getInstance()->find($values['id']);
       }else{
         $group = new Groups();
       }
        
        $group->setName($values['name'])
              ->setDescription($values['description'])
              ->setLevel($values['level'])
              ->setCreatorId($values['creator_id'])
              ->save();


        //add profile to that group
        $phg = new ProfileHasGroup();
        $phg->setGroupId($group->getId())
            ->setProfileId($values['creator_id'])
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

        
    public function addProfileToGroup($group_id, $profile_id){
        try{
            $gp = new GroupProfile();
            $gp -> setGroupId($group_id);
            $gp -> setProfileId($profile_id);
            $gp->save();
            return($gp);
        }catch(Exception $e){
            //already exists
            return true;
        }
    }

    public function removeProfileFromGroup($group_id, $profile_id){
        $gp = GroupProfile::getRepository()->find(array($group_id,$profile_id));
        if ( $gp ){
            $gp -> delete();    
        }
        
    } 

    public function getProfilesInGroupsQuery($groups_id, $filters = array(), $intersect = false){
        //$group = self::getInstance()->find($group_id);
        //$users = $group->getProfiles();

        $q = Profile::getRepository()->createQuery('p')
                // ->select('p.*')
                ->innerJoin('p.GroupProfile gp')
                ->innerJoin('p.sfGuardUser sfg')
                ->whereIn('gp.group_id',$groups_id);

        if($intersect && (count($groups_id) > 1)){
            $q->groupBy('p.id')
              ->having("count(*) = ?", count($groups_id));
        }

        if ( count($filters) > 0 ){
            // "key"       => value
            //i.e: p.firstname => 'Pedro'
            //i.e: p.firstname = ? OR p.lastname = ? => array('Pedro','Pedro')
            foreach ($filters as $key => $filter) {
                $q->andWhere($filter['cond'], $filter['value']);
            }
        }

        return $q;
    }

    public function getProfilesInGroup($group_id, $filters = array()){
        //$group = self::getInstance()->find($group_id);
        //$users = $group->getProfiles();

        $q = Profile::getRepository()->createQuery('p')
                // ->select('p.*')
                ->innerJoin('p.GroupProfile gp')
                ->innerJoin('p.sfGuardUser sfg')
                ->where('gp.group_id ='.$group_id.'');
       /* $pager = new sfDoctrinePager('Profile', 50);
        $pager->setQuery($q);
        $pager->setPage(1);
        $pager->init();
        return($pager-> getResults());*/

        if ( count($filters) > 0 ){
            // "key"       => value
            //i.e: p.firstname => 'Pedro'
            //i.e: p.firstname = ? OR p.lastname = ? => array('Pedro','Pedro')
            foreach ($filters as $key => $filter) {
                $q->andWhere($filter['cond'], $filter['value']);
            }
        }
        // TODO: Pagination
        // 
        // $q->limit(100);

        return($q->execute());
    }

    /** Profiile List
    *   filtering the already added profiles in the current group
    */
    public function getProfilesList($group_id, $filters = array() ){
        // Todo : Add $filters andWhere
        $q = Profile::getRepository()->createQuery('p')
                ->select('p.*')
                ->leftJoin('p.GroupProfile gp ON (gp.group_id ='.$group_id.'  AND p.id=gp.profile_id )')
                ->where('gp.group_id IS NULL');
        if ( count($filters) > 0 ){
            // "key" => value
            // p.firstname => 'Pedro'
            foreach ($filters as $key => $filter) {
                $q->andWhere($filter['cond'], $filter['value']);
            }
        }
        // TODO: Pagination
        // $q->limit(100);

        return $q->execute();
    }

    public function getProfiles($group_id, $kind, $filters = array()){
      $group = GroupsService::getInstance()->find($group_id);
      if ( $kind == 'profiles'){
        $parent = GroupsService::getInstance()->getParent($group_id);
        if ( $parent ){ // if it is subgroup
          $filters = array();
          $filters[] = array("cond" => "gp.profile_id NOT IN 
                                        (SELECT gp2.profile_id
                                         FROM GroupProfile gp2
                                         WHERE gp2.group_id = ?)",
                             "value" => $group_id);
          $profiles = GroupsService::getInstance()->getProfilesInGroup($parent->getId(), $filters);
        }else{
          $profiles = GroupsService::getInstance()->getProfilesList($group_id, $filters);
        }
      } else if($kind == 'group_profiles'){
        $profiles = GroupsService::getInstance()->getProfilesInGroup($group_id, $filters);
      }
      return($profiles);
    }


    public function getParent($group_id){
        $group = self::getInstance()->find($group_id);
        return($group->getParents()->getFirst());
    }


}
