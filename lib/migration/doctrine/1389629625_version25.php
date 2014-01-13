<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version25 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('flash_message', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'type' => 
             array(
              'type' => 'string',
              'length' => '',
             ),
             'name' => 
             array(
              'type' => 'string',
              'length' => '',
             ),
             'active' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'length' => '25',
             ),
             'valid_from' => 
             array(
              'type' => 'date',
              'length' => '25',
             ),
             'valid_until' => 
             array(
              'type' => 'date',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
        $this->createTable('profile_view_flash_message', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'flash_message_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'profile_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('flash_message');
        $this->dropTable('profile_view_flash_message');
    }
}