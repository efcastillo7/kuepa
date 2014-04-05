<?php 
function show($array){
	echo "<ul>";
	foreach ($array as $key => $value){
		if(!is_array($value) && !is_array($key)){
			echo "<li>";
			echo $key . ": " . $value . "<br/>";
			// echo $key . "<br/>";
			echo "</li>";
		}else{
			echo "<li>";
			echo $key . "<br/>";
			show($value);
			echo "</li>";
		}
	}
	echo "</ul>";
}

show($sf_data->getRaw('course'));
 ?>