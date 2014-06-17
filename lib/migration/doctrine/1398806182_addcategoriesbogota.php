<?php

class Addcategoriesbogota extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();

    //insert groups into profile ProyBogota
	  $query = "insert into profile_has_group (select 151, id from groups where id > 12);";
    $q->execute($query);

	//Add categories
	$query = "INSERT INTO group_category (`id`, `name`) VALUES (NULL, 'Localidad'), (NULL, 'Colegio'), (NULL, 'Grado'), (NULL, 'Jornada');";
    $q->execute($query);

	//add cateogories to groups
	//LOCALIDAD
	$query = "UPDATE groups SET group_category_id = 1 WHERE name not like 'COL%' and id > 12 and name not like 'Nocturna' and name not like 'Completa';";
    $q->execute($query);

	//COLEGIO
	$query = "UPDATE groups SET group_category_id = 2 WHERE name like 'COL%';";
    $q->execute($query);

	//GRADO
	$query = "UPDATE groups SET group_category_id = 3 WHERE name like '11';";
    $q->execute($query);

	//JORNADA
	$query = "UPDATE groups SET group_category_id = 4 WHERE name like '%Manana%' OR name like '%Tarde%' OR name like '%Nocturna%' OR name like '%Completa%';";
    $q->execute($query);
  }

  public function down()
  {
  }
}
