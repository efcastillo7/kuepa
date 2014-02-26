<?php

/**
 * ComponentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ComponentTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ComponentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Component');
    }

    public function getById($id){
    public function getCourses(){
    	return self::getInstance()->createQuery()->where('type = ?', Course::TYPE)->orderBy('name asc')->execute();
    }
}