<?php

/**
 * Description of RESTRouteCollection
 *
 * @author grazz
 */
class RESTRouteCollection extends sfRouteCollection {

    public function __construct(array $options) {
        parent::__construct($options);

        if (!isset($this->options['module'])) {
            throw new InvalidArgumentException(sprintf('You must pass a "module" option to %s ("%s" route)', get_class($this), $this->options['name']));
        }

        $this->routes = Array();

        $this->routes[$this->options['module'] . '_create'] = new sfRequestRoute(
                '/' . $this->options['module'], array('module' => $this->options['module'], 'action' => 'create'), array('sf_method' => array('post'))
        );
        
        $this->routes[$this->options['module'] . '_edit'] = new sfRequestRoute(
                '/' . $this->options['module'] . '/:id', array('module' => $this->options['module'], 'action' => 'edit'), array('sf_method' => array('put'), 'id' => '\d+')
        );
        
        $this->routes[$this->options['module'] . '_get'] = new sfRequestRoute(
                '/' . $this->options['module'] . '/:id', array('module' => $this->options['module'], 'action' => 'get'), array('sf_method' => array('get'), 'id' => '\d+')
        );
        
        $this->routes[$this->options['module'] . '_delete'] = new sfRequestRoute(
                '/' . $this->options['module'] . '/:id', array('module' => $this->options['module'], 'action' => 'delete'), array('sf_method' => array('delete'), 'id' => '\d+')
        );
        
        $this->routes[$this->options['module'] . '_list'] = new sfRequestRoute(
                '/' . $this->options['module'], array('module' => $this->options['module'], 'action' => 'list'), array('sf_method' => array('get'))
        );
    }
}
