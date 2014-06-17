<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('kuepa_api', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
