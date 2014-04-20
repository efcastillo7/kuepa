<?php

class ChangeStudentGroups extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
        // add new permissions
        $query = "
	        INSERT INTO  sf_guard_permission VALUES 
	    	(NULL ,  'access_messages',  'Acceder a Mensajes', NOW( ) , NOW( )),
	    	(NULL ,  'access_video_sessions',  'Acceder a Video Tutorias', NOW( ) , NOW( ));
	        ";
        $q->execute($query);

        // add new group
        $query = "
        	INSERT INTO sf_guard_group VALUES (NULL, 'estudiante_bogota', 'Estudiante Bogota', NOW(), NOW());";
        $q->execute($query);

        // add new permissions to group
        $query = "INSERT INTO sf_guard_group_permission VALUES (7,2, NOW(), NOW()), (2,6, NOW(), NOW()), (2,7, NOW(), NOW()), (1,6, NOW(), NOW()), (1,7, NOW(), NOW()), (6,6, NOW(), NOW()), (6,7, NOW(), NOW());";
        $q->execute($query);

        //change bogota users to new group
        $query = "UPDATE sf_guard_user_group SET group_id = 7 WHERE user_id in (SELECT id FROM sf_guard_user WHERE email_address LIKE '%bogota.co%')";
        $q->execute($query);

  }

  public function down()
  {
  }
}
