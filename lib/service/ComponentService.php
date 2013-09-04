<?php

class ComponentService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ComponentService;
        }

        return self::$instance;
    }

    public function getCoursesForUser($profile_id) {
        $courses = Course::getRepository()->getChaptersForUser($profile_id);

        return $courses;
    }

    public function getLessonsForUser($profile_id) {
        $lessons = Lessons::getRepository()->getChaptersForUser($profile_id);

        return $lessons;
    }

    public function getResourcesForUser($profile_id) {
        $lessons = Resources::getRepository()->getChaptersForUser($profile_id);

        return $lessons;
    }

    public function create($type, $values = array()) {
        //default values
        $def_values = array(
            'name' => '',
            'thumbnail' => '',
            'description' => '',
            'level' => '',
            'duration' => 0,
        );
        //merge values
        $values = $values + $def_values;

        //TODO: check for uncosistent

        $component = new Component();
        $component->setName($values['name'])
                ->setThumbnail($values['thumbnail'])
                ->setDescription($values['description'])
                ->setLevel($values['level'])
                ->setProfileId($values['profile_id'])
                ->setDuration($values['duration'])
                ->setType($type)
                ->save();

        return $component;
    }

    public function edit($component_id, $values = array()) {
        $component = Component::getRepository()->find($component_id);

        if ($component) {
            //editable fields
            $values_keys = array('name', 'thumbnail', 'description', 'level', 'profile_id', 'duration');

            foreach ($values_keys as $key) {
                //check if loaded
                if (isset($values[$key])) {
                    $component->set($key, $values[$key]);
                }
            }

            $component->save();
        }

        return $component;
    }

    public function delete($component_id) {
        $component = Component::getRepository()->find($component_id);

        if ($component) {
            $component->delete();
        }

        return;
    }

    public function addUserToComponent($component_id, $user_id) {
        $plp = new ProfileLearningPath();

        $plp->setProfileId($user_id)
                ->setComponentId($component_id)
                ->save();

        //exception?
        return;
    }

    public function removeUserFromComponent($component_id, $user_id) {
        $plp = ProfileLearningPath::getRepository()->findByComponentIdAndProfileId($component_id, $user_id);

        if ($plp) {
            $plp->delete();
        }

        return;
    }

    public function getUsersFromComponent($component_id, $type = 1, $deep = false) {
        //type for the time beeing is dummy, will be Student, Teacher, Head, etc.

        $q = Profile::getRepository()->createQuery('p')
                ->innerJoin('p.ProfileLearningPath plp')
                ->where('plp.component_id = ?', $component_id);
        // ->andWhere('plp.type = ?','e') //type of profile
        //deep is set to check all tree users like "college users"

        return $q->execute();
    }

    public function getChilds($component_id, $type = null, $orderBy = 'asc') {
        //TODO: check orderBy parameter SQLINJ

        $q = Component::getRepository()->createQuery('child')
                ->innerJoin('child.LearningPath lp ON child.id = lp.child_id')
                ->where('lp.parent_id = ?', $component_id)
                ->orderBy("lp.position $orderBy");

        if ($type) {
            $q->andWhere('child.type = ? ', $type);
        }

        return $q->execute();
    }

    public function getLastChildPosition($component_id) {
        $q = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $component_id)
                ->orderBy('lp.position desc')
                ->limit(1)
                ->fetchOne();
        if ($q) {
            return $q->getPosition();
        }

        return 0;
    }

    public function addChildToComponent($parent_id, $child_id) {
        //get last item from parent
        $position = self::getInstance()->getLastChildPosition($parent_id) + 1;

        $lp = new LearningPath();
        $lp->setParentId($parent_id)
                ->setChildId($child_id)
                ->setPosition($position)
                ->save();

        return;
    }

    public function getChildPosition($parent_id, $child_id) {
        $child = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $component_id)
                ->andWhere('lp.child_id = ?', $child_id)
                ->limit(1)
                ->fetchOne();

        if ($child) {
            return $child->getPosition();
        }

        return null;
    }

    public function removeChildFromComponent($parent_id, $child_id) {
        //get position child
        $child = LearningPath::getRepository()->createQuery('lp')
                ->where('lp.parent_id = ?', $parent_id)
                ->andWhere('lp.child_id = ?', $child_id)
                ->limit(1)
                ->fetchOne();

        //if exists
        if ($child) {
            //get position to update order
            $position = $child->getPosition();
            //remove
            $child->delete();
            //update next positions
            $q = LearningPath::getRepository()->createQuery('lp')
                    ->update()
                    ->set('position', '(position - 1)')
                    ->where('parent_id = ?', $parent_id)
                    ->andWhere('position > ?', $position)
                    ->execute();
        }

        return;
    }

    public function addOrderedChildrenToComponent($parent_id, $children_hash) {
        //children hash must be: key -> learning_path position, value -> existing child component
        foreach ($children_hash as $position => $child_component) {
            $lp = new LearningPath();
            $lp->setParentId($parent_id);
            $lp->setChildId($child_component->getId());
            $lp->setPosition($position);
            $lp->save();
        }
    }

}
