<?php

class Addgroupstoprofile extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();

  	$query = "
        	INSERT INTO profile_has_group (select creator_id, id from groups);";
        $q->execute($query);
  }

  public function down()
  {
  }
}
