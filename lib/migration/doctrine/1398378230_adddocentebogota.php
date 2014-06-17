<?php

class Adddocentebogota extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();

  	$query = "
        	INSERT INTO sf_guard_group VALUES (NULL, 'docente_bogota', 'Docente Bogota', NOW(), NOW());";
        $q->execute($query);
  }

  public function down()
  {
  }
}
