<?php

class KeyValueTrioMultipleHydrator extends Doctrine_Hydrator_Abstract
{
    public function hydrateResultSet($stmt)
    {
        $results = $stmt->fetchAll(Doctrine_Core::FETCH_NUM);
        $array = array();
        if(count($results)){
            $first = $results[0];
            $count_values = count($first);

            foreach ($results as $result)
            {
                $array[$result[0]][$result[1]] = array();
                for($i=2;$i<$count_values;$i++){
                    $array[$result[0]][$result[1]][] = $result[$i];
                }
            }
        }

        return $array;
    }
}
