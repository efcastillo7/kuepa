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