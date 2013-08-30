<?php

function generate_url($route, Array $query = Array(), $absolute = false) {
    if(!function_exists('url_for')) {
        throw new Exception('ImprovedUrlHelper cannot work without UrlHelper');
    }
    
    return url_for($route . '?' . http_build_query($query), $absolute);
}