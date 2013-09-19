<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addfks extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('calendar_event', 'calendar_event_profile_id_profile_id', array(
             'name' => 'calendar_event_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('component', 'component_profile_id_profile_id', array(
             'name' => 'component_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('learning_path', 'learning_path_parent_id_component_id', array(
             'name' => 'learning_path_parent_id_component_id',
             'local' => 'parent_id',
             'foreign' => 'id',
             'foreignTable' => 'component',
             ));
        $this->createForeignKey('learning_path', 'learning_path_child_id_component_id', array(
             'name' => 'learning_path_child_id_component_id',
             'local' => 'child_id',
             'foreign' => 'id',
             'foreignTable' => 'component',
             ));
        $this->createForeignKey('message_recipient', 'message_recipient_recipient_id_profile_id', array(
             'name' => 'message_recipient_recipient_id_profile_id',
             'local' => 'recipient_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('message_recipient', 'message_recipient_message_id_message_id', array(
             'name' => 'message_recipient_message_id_message_id',
             'local' => 'message_id',
             'foreign' => 'id',
             'foreignTable' => 'message',
             ));
        $this->createForeignKey('note', 'note_resource_id_component_id', array(
             'name' => 'note_resource_id_component_id',
             'local' => 'resource_id',
             'foreign' => 'id',
             'foreignTable' => 'component',
             ));
        $this->createForeignKey('note', 'note_profile_id_profile_id', array(
             'name' => 'note_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('profile', 'profile_sf_guard_user_id_sf_guard_user_id', array(
             'name' => 'profile_sf_guard_user_id_sf_guard_user_id',
             'local' => 'sf_guard_user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('profile_college', 'profile_college_college_id_college_id', array(
             'name' => 'profile_college_college_id_college_id',
             'local' => 'college_id',
             'foreign' => 'id',
             'foreignTable' => 'college',
             ));
        $this->createForeignKey('profile_college', 'profile_college_profile_id_profile_id', array(
             'name' => 'profile_college_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('profile_component_completed_status', 'profile_component_completed_status_component_id_component_id', array(
             'name' => 'profile_component_completed_status_component_id_component_id',
             'local' => 'component_id',
             'foreign' => 'id',
             'foreignTable' => 'component',
             ));
        $this->createForeignKey('profile_component_completed_status', 'profile_component_completed_status_profile_id_profile_id', array(
             'name' => 'profile_component_completed_status_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('profile_learning_path', 'profile_learning_path_component_id_component_id', array(
             'name' => 'profile_learning_path_component_id_component_id',
             'local' => 'component_id',
             'foreign' => 'id',
             'foreignTable' => 'component',
             ));
        $this->createForeignKey('profile_learning_path', 'profile_learning_path_profile_id_profile_id', array(
             'name' => 'profile_learning_path_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('resource_data', 'resource_data_profile_id_profile_id', array(
             'name' => 'resource_data_profile_id_profile_id',
             'local' => 'profile_id',
             'foreign' => 'id',
             'foreignTable' => 'profile',
             ));
        $this->createForeignKey('resource_data', 'resource_data_resource_id_component_id', array(
             'name' => 'resource_data_resource_id_component_id',
             'local' => 'resource_id',
             'foreign' => 'id',
             'foreignTable' => 'component',
             ));
        $this->createForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_forgot_password_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_group_permission_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_group_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_remember_key_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_group_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_user_group_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_permission_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_user_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('calendar_event', 'calendar_event_profile_id_profile_id');
        $this->dropForeignKey('component', 'component_profile_id_profile_id');
        $this->dropForeignKey('learning_path', 'learning_path_parent_id_component_id');
        $this->dropForeignKey('learning_path', 'learning_path_child_id_component_id');
        $this->dropForeignKey('message_recipient', 'message_recipient_recipient_id_profile_id');
        $this->dropForeignKey('message_recipient', 'message_recipient_message_id_message_id');
        $this->dropForeignKey('note', 'note_resource_id_component_id');
        $this->dropForeignKey('note', 'note_profile_id_profile_id');
        $this->dropForeignKey('profile', 'profile_sf_guard_user_id_sf_guard_user_id');
        $this->dropForeignKey('profile_college', 'profile_college_college_id_college_id');
        $this->dropForeignKey('profile_college', 'profile_college_profile_id_profile_id');
        $this->dropForeignKey('profile_component_completed_status', 'profile_component_completed_status_component_id_component_id');
        $this->dropForeignKey('profile_component_completed_status', 'profile_component_completed_status_profile_id_profile_id');
        $this->dropForeignKey('profile_learning_path', 'profile_learning_path_component_id_component_id');
        $this->dropForeignKey('profile_learning_path', 'profile_learning_path_profile_id_profile_id');
        $this->dropForeignKey('resource_data', 'resource_data_profile_id_profile_id');
        $this->dropForeignKey('resource_data', 'resource_data_resource_id_component_id');
        $this->dropForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id');
        $this->dropForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id');
    }
}