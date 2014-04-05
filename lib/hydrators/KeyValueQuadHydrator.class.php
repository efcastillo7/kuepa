<?php

class KeyValueQuadHydrator extends Doctrine_Hydrator_Abstract
{
    public function hydrateResultSet($stmt)
    {
        $results = $stmt->fetchAll(Doctrine_Core::FETCH_NUM);
        $array = array();

        foreach ($results as $result)
        {
            $array[$result[0]][$result[1]][$result[2]] = $result[3];
        }

        return $array;
    }
}
