<?php
function getStatusColor($stats){
    if($stats < 35){
        return "red";
    }else if($stats < 70){
        return "orange";
    }else{
        return "green";
    }
}

function getProgressNumber($index_value){
	if($index_value < 0.2){
		return "one";
	}else if ($index_value < 0.40) {
		return "two";
	}else if ($index_value < 0.60) {
		return "three";
	}else if ($index_value < 0.80) {
		return "four";
	}else{
		return "five";
	}
}