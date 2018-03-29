<?php 
function base_route($path=""){
    $route = request()->segment(1);
    if($path!=""){
        return $route."/".$path;
    }
    return $route;
}
