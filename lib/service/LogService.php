<?php

class LogService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new LogService;
        }

        return self::$instance;
    }
}
