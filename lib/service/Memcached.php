<?php

/**
 * Memcached cache driver
 */
class Doctrine_Cache_Memcached extends Doctrine_Cache_Driver
{
    /**
     * @var Memcache $_memcache     memcache object
     */
    protected $_memcache = null;

    /**
     * constructor
     *
     * @param array $options        associative array of cache driver options
     */
    public function __construct($options = array())
    {
        if ( ! extension_loaded('memcached')) {
            throw new Doctrine_Cache_Exception('In order to use Memcached driver, the memcached extension must be loaded.');
        }
        parent::__construct($options);

        if (isset($options['servers'])) {
            $value = $options['servers'];
            if (isset($value['host'])) {
                // in this case, $value seems to be a simple associative array (one server only)
                $value = array(0 => $value); // let's transform it into a classical array of associative arrays
            }
            $this->setOption('servers', $value);
        }

        $this->_memcache = new Memcached;
        
        foreach ($this->_options['servers'] as $server) {
            if ( ! array_key_exists('port', $server)) { $server['port'] = 11211; }
            $this->_memcache->addServer($server['host'], $server['port']);
        }
    }

    /**
     * Test if a cache record exists for the passed id
     *
     * @param string $id cache id
     * @return mixed  Returns either the cached data or false
     */
    protected function _doFetch($id, $testCacheValidity = true)
    {        
        return $this->_memcache->get($id);
    }

    /**
     * Test if a cache is available or not (for the given id)
     *
     * @param string $id cache id
     * @return mixed false (a cache is not available) or "last modified" timestamp (int) of the available cache record
     */
    protected function _doContains($id)
    {
        return (bool) $this->_memcache->get($id);
    }

    /**
     * Save a cache record directly. This method is implemented by the cache
     * drivers and used in Doctrine_Cache_Driver::save()
     *
     * @param string $id        cache id
     * @param string $data      data to cache
     * @param int $lifeTime     if != false, set a specific lifetime for this cache record (null => infinite lifeTime)
     * @return boolean true if no problem
     */
    protected function _doSave($id, $data, $lifeTime = false)
    {
        return $this->_memcache->set($id, $data, $lifeTime);
    }

    /**
     * Remove a cache record directly. This method is implemented by the cache
     * drivers and used in Doctrine_Cache_Driver::delete()
     *
     * @param string $id cache id
     * @return boolean true if no problem
     */
    protected function _doDelete($id)
    {
        return $this->_memcache->delete($id);
    }
    
    protected function sendMemcacheCommand($command){
    
        $buf='';
        foreach ($this->_options['servers'] as $server) {
            
            $s = @fsockopen($server['host'], $server['port']);
            if (!$s){
                die("Cant connect to:".$server['host'].':'.$server['port']);
            }
        
            fwrite($s, $command."\r\n");
            
            while ((!feof($s))) {
                $buf .= fgets($s, 256);
                if (strpos($buf,"END\r\n")!==false) {
                    break;
                }
                if (strpos($buf,"DELETED\r\n")!==false || strpos($buf,"NOT_FOUND\r\n")!==false) {
                    break;
                }
                if (strpos($buf,"OK\r\n")!==false) {
                    break;
                }
            }
        }
    
        return $buf;
    }
    
    /**
     * Fetch an array of all keys stored in cache
     *
     * @return array Returns the array of cache keys
     */
    public function _getCacheKeys() {
    
        $res = array();
    
        $string = $this->sendMemcacheCommand("stats items");
    
        $lines = explode("\r\n", $string);
            
        $slabs = array();
    
        foreach($lines as $line) {
            if (preg_match("/STAT items:([0-9]*):/", $line, $matches) == 1) {
                                    
                if (isset($matches[1])) {
                    if (!in_array($matches[1], $slabs)) {
                        $slabs[] = $matches[1];
                            
                        $string = $this->sendMemcacheCommand("stats cachedump " . $matches[1] . " 100");
                            
                        preg_match_all("/ITEM (.*?) /", $string, $matches);
                        $res = array_merge($res, $matches[1]);
                    }
                }
            }
        }
                
        return $res;
    }
    
    /**
     * Flush all cache
     *
     */
    public function flush()
    {
        return $this->_memcache->flush();
    }
    
}