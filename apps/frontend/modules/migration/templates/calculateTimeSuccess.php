calculateTime.php
<?php
    foreach($resources as $key => $resource){
      echo $resource->getId().' '.$resource->getName().' '.$resource->getDuration().'<br >';
    }
?>