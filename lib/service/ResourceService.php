<?php

class ResourceService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ResourceService;
        }

        return self::$instance;
    }    

}
