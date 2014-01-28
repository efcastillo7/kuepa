<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version25 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('mail_message', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'profile_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'subject' => 
             array(
              'type' => 'varchar',
              'length' => '255',
             ),
             'email' => 
             array(
              'type' => 'varchar',
              'length' => '100',
             ),
             'name' => 
             array(
              'type' => 'varchar',
              'length' => '100',
             ),
             'content' => 
             array(
              'type' => 'clob',
              'length' => '',
             ),
             'priority' => 
             array(
              'type' => 'integer',
              'default' => '5',
              'length' => '8',
             ),
             'status' => 
             array(
              'type' => 'varchar',
              'default' => 'pending',
              'length' => '10',
             ),
             'sent_at' => 
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'creator_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
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
    }

    public function down()
    {
        $this->dropTable('mail_message');
    }
}