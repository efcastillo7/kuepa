<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
  }

  public function configureDoctrine(Doctrine_Manager $manager)
  {
    // Enable callbacks so that softDelete behavior can be used
    $manager->setAttribute(Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true);
    
    // Gestion de CACHE
    $memcachePort = sfConfig::get('app_memcache_port');
    $memcacheIp = sfConfig::get('app_memcache_ip');
    
    if ( $memcacheIp && $memcachePort )
    {
        $cacheDriver = new Doctrine_Cache_Memcached ( array ( 'servers' => array('host' => $memcacheIp, 'port' => $memcachePort) ) );
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);

        // $cacheDriver->flush();
    }
    
    // Registro de Customs Hydrators
    $manager->registerHydrator('HYDRATE_KEY_VALUE_UNIQUE', 'KeyValueUniqueHydrator');
    $manager->registerHydrator('HYDRATE_KEY_VALUE_PAIR', 'KeyValuePairHydrator');
    $manager->registerHydrator('HYDRATE_KEY_VALUE_PAIR_MULTIPLE', 'KeyValuePairMultipleHydrator');
    $manager->registerHydrator('HYDRATE_KEY_VALUE_TRIO', 'KeyValueTrioHydrator');
    $manager->registerHydrator('HYDRATE_KEY_VALUE_TRIO_MULTIPLE', 'KeyValueTrioMultipleHydrator');
    $manager->registerHydrator('HYDRATE_KEY_VALUE_QUAD', 'KeyValueQuadHydrator');
    
    
  }
}
