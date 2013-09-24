<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addresourcedata extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('resource_data', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 8,
             ),
             'resource_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'position' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'content' => 
             array(
              'type' => 'blob',
              'length' => NULL,
             ),
             'enabled' => 
             array(
              'type' => 'boolean',
              'notnull' => true,
              'default' => 1,
              'length' => 25,
             ),
             'tags' => 
             array(
              'type' => 'string',
              'length' => NULL,
             ),
             'profile_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'parent_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'duration' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'level' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'beginner',
              1 => 'intermediate',
              2 => 'advance',
              ),
              'length' => NULL,
             ),
             'type' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'document_type' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'pdf',
              1 => 'image',
              ),
              'length' => NULL,
             ),
             'video_type' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'youtube',
              1 => 'vimeo',
              2 => 'embebed',
              ),
              'length' => NULL,
             ),
             'path' => 
             array(
              'type' => 'string',
              'length' => NULL,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'deleted_at' => 
             array(
              'notnull' => false,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'indexes' => 
             array(
              'resource_data_type' => 
              array(
              'fields' => 
              array(
               0 => 'type',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('resource_data');
    }
}