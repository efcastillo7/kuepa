<?php

class ResourceService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ResourceService;
        }

        return self::$instance;
    }

    public function create($values = array()) {
        $resource = ComponentService::getInstance()->create(Resource::TYPE, $values);

        return $resource;
    }

    public function edit($resource_id, $values = array()) {
        //check if course
        return ComponentService::getInstance()->edit($resource_id, $values);
    }

    public function delete($resource_id) {
        //check if course
        return ComponentService::getInstance()->delete($resource_id);
    }

}
